/*
 * @copyright     2022 beikeshop.com - All Rights Reserved.
 * @link          https://beikeshop.com
 * @Author        pu shuo <pushuo@guangda.work>
 * @Date          2022-08-17 15:42:46
 * @LastEditTime  2023-10-18 17:46:11
 */

// Example starter JavaScript for disabling form submissions if there are invalid fields
$(function () {
  var forms = document.querySelectorAll(".needs-validation");


  $(document).on('click', '.submit-form', function(event) {
    const form = $(this).attr('form');

    if ($(`form#${form}`).find('button[type="submit"]').length > 0) {
      $(`form#${form}`).find('button[type="submit"]')[0].click();
    } else {
      $(`form#${form}`).submit();
    }
  });


  $(document).on('submit', 'form', function(event) {
    if (!$(this).hasClass('no-load')) {
      layer.load(2, { shade: [0.2, '#fff'] });
    }
  });

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
        $('.nav-link, .nav-item').removeClass('error-invalid');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').removeClass('d-block');


        $('.invalid-feedback').each(function(index, el) {
          if ($(el).css('display') == 'block') {
            layer.msg(lang.error_form, () => {});


            if ($(el).siblings('div[class^="el-"]')) {
              $(el).siblings('div[class^="el-"]').find('.el-input__inner').addClass('error-invalid-input')
            }

            if ($(el).parents('.tab-pane')) {

              $(el).parents('.tab-pane').each(function(index, el) {
                const id = $(el).prop('id');
                $(`a[href="#${id}"], button[data-bs-target="#${id}"]`).addClass('error-invalid')[0].click();
              })
            }


            if ($('.main-content > #content').data('scroll') != 1) {
              $('.main-content > #content').data('scroll', 1);
              setTimeout(() => {
                $('.main-content > #content').animate({
                  scrollTop: $(el).offset().top - 100
                }, 500, () => {
                  $('.main-content > #content').data('scroll', 0);
                });
              }, 200);
            }
          }
        });
      },
      false
    );
  });
});
