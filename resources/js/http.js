/*
 * @copyright     2022 beikeshop.com - All Rights Reserved.
 * @link          https://beikeshop.com
 * @Author        pu shuo <pushuo@guangda.work>
 * @Date          2022-08-02 19:19:52
 * @LastEditTime  2024-08-29 22:54:53
 */

window.axios = require('axios');

const token = document.querySelector('meta[name="csrf-token"]').content;
const base = document.querySelector('base').href;

const instance = axios.create({
  headers: {'X-CSRF-TOKEN': token},
});

axios.defaults.timeout = 0;
// axios.defaults.baseURL = process.env.NODE_ENV == 'production' ? process.env.VUE_APP_BASE_URL + '/' : '/';
// console.log(process.env.VUE_APP_BASE_URL)
axios.defaults.baseURL = base;
export default {
  /**
   * get
   * @param url
   * @returns {AxiosPromise<any>}
   */
  get (url, params, {hmsg, hload, base}={}) {
    return this.request('get', url, params = params, {hmsg, hload, base});
  },

  /**
   * post
   *
   * @param url
   * @param params
   * @returns {AxiosPromise<any>}
   */

  post (url, params, {hmsg, hload, base}={}) {
    return this.request('post', url, params, {hmsg, hload, base});
  },

  /**
  * delete
  * @param url
  * @param params
  * @returns {Promise}
  */

  delete (url, params, {hmsg, hload, base}={}) {
    return this.request('delete', url, params, {hmsg, hload, base});
  },

  /**
  * put
  * @param url
  * @param params
  * @returns {Promise}
  */

  put (url, params, {hmsg, hload, base}={}) {
    return this.request('put', url, params, {hmsg, hload, base});
  },


  /**
   *
   * @param method
   * @param url
   * @param params
   * @param showError
   * @returns {Promise<any>}
   */

  request(method, url, params = {}, {hmsg, hload, base} = {}) {
    if (!hload) {
      layer.load(2, {shade: [0.3,'#fff'] })
    }

    if (base) {
      axios.defaults.baseURL = base;
    }

    return new Promise((resolve, reject) => {
      axios({method: method, url: url, [method == 'get' ? 'params' : 'data']: params}).then((res) => {
        if (res) {
          resolve(res.data);
        } else {
          reject(res.data);
          if (!hmsg) return layer.msg(res.data.message, ()=>{});
        }
      }).catch((res) => {
        reject(res);
        if (!hmsg) {
          layer.msg(res.response.data.message || res.message,{time: 3000}, ()=>{});
        }
      }).finally(() => {
        layer.closeAll('loading')
      });
    });
  }
}
