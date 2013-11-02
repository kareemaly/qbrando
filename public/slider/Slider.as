package  
{
	import com.greensock.events.LoaderEvent;
	import com.greensock.loading.XMLLoader;
	import com.greensock.TweenLite;
	import flash.display.DisplayObject;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import com.greensock.loading.SWFLoader;
	import com.greensock.loading.LoaderMax;

	/**
	 * ...
	 * @author Kareem Mohamed
	 */
	public class Slider extends Sprite
	{
		protected static var instance:Slider = null;
		
		/**
		 * Frames per second
		 * @var Number
		 */
		protected var framesPerSecond:Number;
	
		/**
		 * Seconds per slide..
		 * @var Number
		 */
		protected var secondsPerSlide:Number = 0;
		
		/**
		 * @var Vector
		 */
		protected var slides:Vector.<MovieClip> = new Vector.<MovieClip>();
		
		/**
		 * @var MovieClip
		 */
		protected var currentSlide:MovieClip;
		
		/**
		 * @var Mask
		 */
		protected var transitionMask:Mask;
		
		/**
		 * Time per item in milliseoncds
		 * @param	timePerItem
		 */
		public function Slider(transitionMask:Mask, secondsPerSlide:Number, framesPerSecond:Number)
		{
			this.secondsPerSlide = secondsPerSlide;
			
			this.framesPerSecond = framesPerSecond;
			
			this.transitionMask = transitionMask;
		}
		
		/**
		 * Get singleton instance
		 * @param timePerItem default to 5 seconds
		 * @return Slider
		 */
		public static function getInstance( transitionMask:Mask, secondsPerSlide:Number = 5, framesPerSecond:Number = 50 ):Slider
		{
			if(instance == null) instance = new Slider( transitionMask, secondsPerSlide, framesPerSecond );
			
			return instance;
		}
		
		/**
		 * @param	xml
		 */
		public function loadFromXML( xml:String, onProgress:Function ):void
		{
			LoaderMax.activate([SWFLoader]);
			
			var loader:XMLLoader = new XMLLoader(xml, {
										onComplete:allCompleteHandler,
										onChildProgress:onProgress,
										onChildComplete:childCompleteHandler,
										maxConnections: 1
									});
			
			loader.load();
		}
		
		/**
		 * Start the slider by playing the next slide
		 */
		public function start()
		{
			addChild(transitionMask);
			
			this.nextSlide();
		}
		
		/**
		 * Load next slide
		 */
		public function nextSlide()
		{
			var slide = decideNextSlide();
			
			playSlide(slide, delayCallToNextSlide);
		}
		
		/**
		 * 
		 */
		public function delayCallToNextSlide()
		{
			var that = this;
			
			TweenLite.delayedCall(this.secondsPerSlide, function()
			{
				that.nextSlide();
			});
		}
		
		/**
		 * @return Slide
		 */
		protected function decideNextSlide():MovieClip
		{
			var index:uint = getCurrentSlideIndex() + 1;
			
			if (index < slides.length)
			{
				return slides[index];
			}
			
			else
			{
				return slides[0];
			}
		}
		
		/**
		 * @return uint
		 */
		public function getCurrentSlideIndex():uint
		{
			return slides.indexOf(currentSlide);
		}
		
		/**
		 * @param	index
		 */
		public function playSlideByIndex( index:uint ):void
		{
			if (index < slides.length)
			{
				playSlide( slides[index] );
			}
		}
		
		/**
		 * @param	slide
		 */
		public function playSlide( slide:MovieClip, onComplete:Function = null ):void
		{
			// If first time to play slide....
			if (! currentSlide)
			{
				currentSlide = slide;
				
				currentSlide.gotoAndPlay(1);
				
				addChild(currentSlide);

				if (onComplete != null) onComplete();
			}
			
			else
			{
				addChild(slide);
				
				// Put the new slide in the back and current slide in the front
				// to play the transition on...
				this.swapChildren(currentSlide, slide);
				
				this.transitionMask.startingPoint();
				
				currentSlide.mask = this.transitionMask;
				
				this.transitionMask.playTransition(function() {
					
					// Play slide on half complete
					slide.gotoAndPlay(1);

				}, function() {

					// On Complete reset current slide and set current slide to the new one					
					removeChild(currentSlide);
					
					currentSlide.gotoAndStop(1);
					
					currentSlide = slide;

					if (onComplete != null) onComplete();
				});
			}
		}
		
		/**
		 * @param	e
		 */
		protected function childCompleteHandler(e:LoaderEvent):void
		{
			// Push to the loaded slides
			slides.push((e.target.rawContent as MovieClip));
		
			// If this was the first slide
			if (slides.length == 1)
			{
				// Dispatch ready event
				dispatchEvent(new SliderEvent(SliderEvent.READY, true));	
			}
		}
		
		/**
		 * @param	e
		 */
		protected function allCompleteHandler(e:LoaderEvent):void
		{
			dispatchEvent(new SliderEvent(SliderEvent.FINISHED));
		}
	}
}