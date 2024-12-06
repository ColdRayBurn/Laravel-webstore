/*
 * @copyright     2022 beikeshop.com - All Rights Reserved.
 * @link          https://beikeshop.com
 * @Author        pu shuo <pushuo@guangda.work>
 * @Date          2022-09-09 19:16:39
 * @LastEditTime  2024-01-14 19:23:10
 */

export default {
  /**
   * @description:
   * @return {*}
   */
  getCarts() {
    $(document).ready(() => {
      $http.get('carts/mini', null, {hload: true}).then((res) => {
        $('#offcanvas-right-cart').html(res.data.html);
        if (!res.data.quantity_all) {
          $('.cart-badge-quantity').hide();
        } else {
          $('.cart-badge-quantity').show().html(res.data.quantity_all > 99 ? '99+' : res.data.quantity_all);
        }
      })
    })
  },

  /**
   * @description:
   * @param {*} sku_id  id
   * @param {*} quantity
   * @param {*} isBuyNow
   * @return {*}  Promise
   */
  addCart({sku_id, quantity = 1, isBuyNow = false}, event, callback) {
    if (!config.isLogin && !config.guestCheckout) {
      this.openLogin()
      return;
    }

    const $btn = $(event);
    const btnHtml = $btn.html();
    const loadHtml = '<span class="spinner-border spinner-border-sm"></span>';
    $btn.html(loadHtml).prop('disabled', true);
    $(document).find('.tooltip').remove();

    $http.post('/carts', {sku_id, quantity, buy_now: isBuyNow}, {hload: !!event}).then((res) => {
      this.getCarts();
      if (!isBuyNow) {
        layer.msg(res.message)
      }

      if (callback) {
        callback(res)
      }
    }).finally(() => {$btn.html(btnHtml).prop('disabled', false)})
  },

  addWishlist(id, event) {
    if (!config.isLogin) {
      this.openLogin()
      return;
    }

    const $btn = $(event);
    const btnHtml = $btn.html();
    const isWishlist = $btn.attr('data-in-wishlist') * 1;
    const loadHtml = '<span class="spinner-border spinner-border-sm"></span>';
    $(document).find('.tooltip').remove();

    if (isWishlist) {
      $btn.html(loadHtml).prop('disabled', true);
      $http.delete(`account/wishlist/${isWishlist}`, null, {hload: true}).then((res) => {
        layer.msg(res.message)
        $btn.attr('data-in-wishlist', '0');
      }).finally((e) => {
        $btn.html(btnHtml).prop('disabled', false).find('i.bi').prop('class', 'bi bi-heart')
      })
    } else {
      $btn.html(loadHtml).prop('disabled', true);
      $http.post('account/wishlist', {product_id: id}, {hload: true}).then((res) => {
        layer.msg(res.message)
        $btn.attr('data-in-wishlist', res.data.id);
        $btn.html(btnHtml).prop('disabled', false).find('i.bi').prop('class', 'bi bi-heart-fill')
      }).catch((e) => {
        $btn.html(btnHtml).prop('disabled', false)
      })
    }
  },

  openLogin() {
    layer.open({
      type: 2,
      title: '',
      shadeClose: true,
      scrollbar: false,
      area: ['900px', '600px'],
      skin: 'login-pop-box',
      content: 'login?iframe=true'
    });
  },

  productQuickView(id, callback) {
    layer.open({
      type: 2,
      title: '',
      shadeClose: true,
      scrollbar: false,
      area: ['1000px', '600px'],
      skin: 'login-pop-box',
      content: `products/${id}?iframe=true`
    });
  },

  getQueryString(name, defaultValue) {
    const reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)');
    const r = window.location.search.substr(1).match(reg);
    if (r != null) {
      return decodeURIComponent(r[2]);
    }

    return typeof(defaultValue) != 'undefined' ? defaultValue : '';
  },

  removeURLParameters(url, ...parameters) {
    const parsed = new URL(url);
    parameters.forEach(e => parsed.searchParams.delete(e))
    return parsed.toString()
  },

  updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
      return uri + separator + key + "=" + value;
    }
  },

  openWin(url, name = '', iWidth = 700, iHeight = 500) {
    var iTop = (window.screen.height - 30 - iHeight) / 2;
    var iLeft = (window.screen.width - 10 - iWidth) / 2;
    window.open(url, name, 'height=' + iHeight + ',innerHeight=' + iHeight
    + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft
    + ',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
  },


  loadScript(url, callback) {

    if (!document.querySelector(`script[src="${url}"]`)) {

      const script = document.createElement('script');
      script.src = url;

      document.head.appendChild(script);

      script.onload = function () {
        callback && callback();
      }
    } else {
      callback && callback();
    }
  },


  loadStyle(url) {

    if (!document.querySelector(`link[href="${url}"]`)) {

      const link = document.createElement('link');
      link.href = url;
      link.rel = 'stylesheet';

      document.head.appendChild(link);
    }
  },


  productImageResize11() {
    if ($('.image-old').length && $('.image-old').width() > 0) {
      $('.image-old').height($('.image-old').width())
    }
  }
}
