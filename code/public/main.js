// $('document').ready(function(){
// 	console.log("ready")

		
// })
$(".preflop").click(function(){
	console.log('preflop')
	var y1 = $('#yc1').attr("data-cardForm");
	var y2 = $('#yc2').attr("data-cardForm");
	var y3 = $('#yc3').attr("data-cardForm");
	var y4 = $('#yc4').attr("data-cardForm");

	var query = "/calc/pre/" + y1 + "/" + y2 + "/" + y3 + "/" + y4 
	$.ajax({
		url: query,
		type: 'GET',
		complete: function(response){
			console.log(response.responseText)

			var numbers = $.parseJSON(response.responseText)
			$("#yourwin").html(numbers.value)
			$("#theirwin").html(numbers.value2)
			//$("#yourwin").html(response.responseText)
			//$("#yourwin").html(response.responseText)
		}
	})
});

$(".flop").click(function(){
	console.log('flop')
	var y1 = $('#yc1').attr("data-cardForm");
	var y2 = $('#yc2').attr("data-cardForm");
	var y3 = $('#yc3').attr("data-cardForm");
	var y4 = $('#yc4').attr("data-cardForm");
	var y5 = $('#bc1').attr("data-cardForm");
	var y6 = $('#bc2').attr("data-cardForm");
	var y7 = $('#bc3').attr("data-cardForm");
	console.log(y1 + y2 + y3 +y4 +y5 + y6 + y7)
	
	var query = "/calc/flop/" + y1 + "/" + y2 + "/" + y3 + "/" + y4 + "/" + y5 + "/" + y6 
	$.ajax({
		url: query,
		type: 'GET',
		complete: function(response){
			console.log(response.responseText)

			var numbers = $.parseJSON(response.responseText)
			$("#yourwin").html(numbers.value)
			$("#theirwin").html(numbers.value2)
			//$("#yourwin").html(response.responseText)
			//$("#yourwin").html(response.responseText)
		}
	})
});

// y1: $('#yc1').attr(data-cardForm),
// 				y2: $('#yc2').attr(data-cardForm),
// 				t1: $('#tc1').attr(data-cardForm),
// 				t2: $('#tc2').attr(data-cardForm),
// 				b1: $('#b1').attr(data-cardForm),
// 				b2: $('#b2').attr(data-cardForm),
// 				b3: $('#b3').attr(data-cardForm),
// 				b4: $('#b4').attr(data-cardForm),
// 				b5: $('#b5').attr(data-cardForm)