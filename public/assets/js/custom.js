// button add remove
function incrementValue(e) {
  e.preventDefault();
  var fieldName = $(e.target).data("field");
  var parent = $(e.target).closest("div");
  var currentVal = parseInt(
    parent.find("input[name=" + fieldName + "]").val(),
    10
  );

  if (!isNaN(currentVal)) {
    parent.find("input[name=" + fieldName + "]").val(currentVal + 1);
  } else {
    parent.find("input[name=" + fieldName + "]").val(0);
  }
}

function decrementValue(e) {
  e.preventDefault();
  var fieldName = $(e.target).data("field");
  var parent = $(e.target).closest("div");
  var currentVal = parseInt(
    parent.find("input[name=" + fieldName + "]").val(),
    10
  );

  if (!isNaN(currentVal) && currentVal > 0) {
    parent.find("input[name=" + fieldName + "]").val(currentVal - 1);
  } else {
    parent.find("input[name=" + fieldName + "]").val(0);
  }
}

$(".input-group").on("click", ".button-plus", function (e) {
  incrementValue(e);
});

$(".input-group").on("click", ".button-minus", function (e) {
  decrementValue(e);
});

// button add remove end

// scroll top for category and sub category

// calculate the height of the sub-cat-nav to scroll the contents below that

$('a[href^="#"]').on("click", function (event) {
  var sub_cat_nav_height = $(".sub-cat-nav").height();
  var hash = "#" + $(this).attr("href").split("#")[1];
  var element = $(hash);
  if (element.length) {
    event.preventDefault();
    history.pushState(hash, undefined, hash);
    $("html, body").animate(
      {
        scrollTop: element.offset().top - sub_cat_nav_height - 60,
      },
      500
    );
  }
});

window.addEventListener("popstate", function (e) {
  if (e.state && e.state.startsWith("#") && $(e.state).length) {
    $("html, body").animate(
      {
        scrollTop: $(e.state).offset().top,
      },
      500
    );
  }
});


// scroll top for category and sub category  end

// $(".cat-nav-item").click(function () {

//     $([document.documentElement, document.body]).animate({
//       scrollTop: $("#rest-menus").offset().top - 30
//     }, 500);

// });

// $( ".cat-nav-item" ).click(function() {
//   $( "#rest-menus" ).scroll();
// });

//sticky navbar

// document.addEventListener("DOMContentLoaded", function () {
//   window.addEventListener("scroll", function () {
//     if (window.scrollY > 50) {
//       document.getElementById("navbar_top").classList.add("fixed-top");
//       // add padding top to show content behind navbar
//       navbar_height = document.querySelector(".navbar").offsetHeight;
//       document.body.style.paddingTop = navbar_height + "px";
//     } else {
//       document.getElementById("navbar_top").classList.remove("fixed-top");
//       // remove padding top from body
//       document.body.style.paddingTop = "0";
//     }
//   });
// });

navbar_height = document.querySelector(".navbar").offsetHeight;
document.body.style.paddingTop = navbar_height + "px";
