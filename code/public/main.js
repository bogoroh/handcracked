// $('document').ready(function(){
// 	console.log("ready")

		
// })
	$(".preflop").click(function(){
		console.log('preflop')
		$.ajax({
			url: "/calc/pre",
			type: 'POST',
			data:{
				y1:10,
				y2:10	
			},
			dataType: "json",
			processData:false,
			contentType:'application/json',
			complete: function(response){
				console.log(response);
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