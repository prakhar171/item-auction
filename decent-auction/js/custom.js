	$(".js-height-full").height($(window).height());
	$(".js-height-parent").each(function() {
	    $(this).height($(this).parent().first().height());
	});

	var i = 0;
    var txt = 'Find the right school for your child from the comfort of your home.';
    var speed = 200; /* The speed/duration of the effect in milliseconds */

 //    function typeWriter() {
 //      if (i < txt.length) {
 //        document.getElementById("type").innerHTML += txt.charAt(i);
 //        i++;
 //        setTimeout(typeWriter, speed);
 //      }
 //    }

	// $(document).ready(function(){
	// 	$("#brand").hide()
	//     $(window).scroll(function() {
	//     	if ($(document).scrollTop() > 300) {
	//       		typeWriter();
	//       		$("#brand").show()
	//     	}
	//     	else{
	//     		$("#brand").hide()
	//     	}
	//   	});
	// });

	// Fun Facts
	function count($this) {
	    var current = parseInt($this.html(), 10);
	    current = current + 1; /* Where 50 is increment */

	    $this.html(++current);
	    if (current > $this.data('count')) {
	        $this.html($this.data('count'));
	    } else {
	        setTimeout(function() {
	            count($this)
	        }, 5);
	    }
	}

	$(".stat-timer").each(function() {
	    $(this).data('count', parseInt($(this).html(), 10));
	    $(this).html('0');
	    count($(this));
	});





	$(window).load(function() {
	    $("#preloader").on(500).fadeOut();
	    $(".preloader").on(600).fadeOut("slow");
	});