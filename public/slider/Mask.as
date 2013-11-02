package  
{
	import com.greensock.TweenLite;
	import flash.display.Sprite;
	/**
	 * ...
	 * @author Kareem Mohamed
	 */
	public class Mask extends Sprite
	{
		
		protected var maskWidth:Number;
		protected var maskHeight:Number;
	
		protected var columns:uint = 18;
		protected var rows:uint = 1;
			
		protected var delay:Number = 0.08;
		protected var seconds:Number = 0.3;
		
		protected var square:Sprite;
		
		public function Mask( _width:Number, _height:Number ) 
		{
			maskWidth = _width;
			maskHeight = _height;

			this.generate();
		}
		
		/**
		 * Generate mask
		 */
		protected function generate()
		{	
			var boxWidth = maskWidth / columns;
			var boxHeight = maskHeight / rows;
			
			for (var i:uint = 0; i < columns; i++)
			{
				for (var j:uint = 0; j < rows; j++)
				{
					var square:Sprite = new Sprite();

					square.graphics.beginFill(0x000000);
					square.graphics.drawRect(0,0,boxWidth + 1, boxHeight);
					square.graphics.endFill();
					
					square.x = i * boxWidth;
					square.y = j * boxHeight;
				
					square.name = i + "," + j;
					
					addChild(square);
				}
			}
		}
		
		/**
		 * Starting point of the mask
		 */
		public function startingPoint()
		{
			for (var i:uint = 0; i < columns; i++)
			{
				for (var j:uint = 0; j < rows; j++)
				{
					getChildByName(i + "," + j).scaleX = getChildByName(i + "," + j).scaleY = 1;
				}
			}
		}
		
		/**
		 * Play transition and when complete call the onComplete method
		 * 
		 * @param	onComplete
		 */
		public function playTransition( halfComplete:Function = null,  onComplete:Function = null )
		{
			var timing:uint = 0;
			
			var calculatedTime = 0;
			
			for (var j:uint = 0; j < rows; j++)
			{
				for (var i:uint = 0; i < columns; i++)
				{	
					calculatedTime = seconds + delay * timing;
					TweenLite.to(getChildByName(i + "," + j), seconds, {delay: delay* timing, scaleY:0 } );
					timing ++;
				}
			}
			
			if(halfComplete != null) TweenLite.delayedCall(calculatedTime / 2, halfComplete);
			if(onComplete != null) TweenLite.delayedCall(calculatedTime, onComplete);
		}
		
	}

}