package  
{
	import flash.events.Event;
	
	/**
	 * ...
	 * @author Kareem Mohamed
	 */
	public class SliderEvent extends Event 
	{
		public static const READY:String = "ready";
		public static const FINISHED:String = "finished";
		
		public function SliderEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false) 
		{ 
			super(type, bubbles, cancelable);
		} 
		
		public override function clone():Event 
		{ 
			return new SliderEvent(type, bubbles, cancelable);
		} 
		
		public override function toString():String 
		{ 
			return formatToString("SliderEvent", "type", "bubbles", "cancelable", "eventPhase"); 
		}
		
	}
	
}