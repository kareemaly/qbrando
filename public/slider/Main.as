package  
{
	import com.greensock.events.LoaderEvent;
	import flash.display.Sprite;
	import flash.events.Event;
	/**
	 * ...
	 * @author Kareem Mohamed
	 */
	public class Main extends Sprite
	{
		protected var slider:Slider;
		
		protected var firstSlider:Boolean = true;
		
		public function Main() 
		{
			if (stage) init();
			else addEventListener(Event.ADDED_TO_STAGE, init);
		}
		
		private function init(e:Event = null):void 
		{
			removeEventListener(Event.ADDED_TO_STAGE, init);
			
			// entry point
			slider = Slider.getInstance(new Mask(1068, 377), 10);
			
			slider.loadFromXML("/slider/slides.xml", onProgress);
			
			slider.addEventListener(SliderEvent.READY, sliderIsReady);
		}
		
		/**
		 * @param	event
		 */
		protected function onProgress(event:LoaderEvent):void
		{
			if(firstSlider)
			{
				getChildByName("preloader").width = event.target.progress * 1068;		
			}
		}
		
		/**
		 * @param	e
		 */
		private function sliderIsReady(event:SliderEvent):void
		{
			firstSlider = false;
			
			removeChild(getChildByName("preloader"));
			
			addChild(slider);
			
			slider.start();
		}
		
	}

}