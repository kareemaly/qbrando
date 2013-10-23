<html>
<head>
	<title></title>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script type="text/javascript">

function Person( name, gender ) {

	this.name = name;
	this.gender = gender;

}

Person.prototype.speak = function()
{
	this.talk( { test:this.gender } )
}


Person.prototype.talk = function( urls )
{
	console.log(urls);
}


Person.prototype.speak();

</script>

</head>
<body>
{{ dd($freak) }}


</body>
</html>