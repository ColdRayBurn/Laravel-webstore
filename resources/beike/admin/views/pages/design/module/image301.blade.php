<template id="module-editor-image301-template">
  <div class="image-edit-wrapper">
    <div class="module-editor-row">{{ __('admin/builder.text_set_up') }}</div>
    <div class="module-edit-group">
      <div class="module-edit-title">{{ __('admin/builder.text_add_pictures') }}</div>
      <div class="pb-images-selector" v-for="(item, index) in form.images" :key="index">
        <div class="selector-head" @click="itemShow(index)">
          <div class="left">

            <img :src="thumbnail(item.image['{{ locale() }}'], 40, 40)" class="img-responsive">
          </div>

          <div class="right"><i :class="'el-icon-arrow-'+(item.show ? 'up' : 'down')"></i></div>
        </div>
        <div :class="'pb-images-list ' + (item.show ? 'active' : '')">
          <div class="pb-images-top">
            <pb-image-selector v-model="item.image"></pb-image-selector>
            <div class="tag">{{ __('admin/builder.text_suggested_size') }}:
              <span v-if="!index">760 x 500</span>
              <span v-else>760 x 240</span>
            </div>
          </div>
          <link-selector v-model="item.link"></link-selector>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
Vue.component('module-editor-image301', {
  template: '#module-editor-image301-template',

  props: ['module'],

  data: function () {
    return {
      form: null
    }
  },

  watch: {
    form: {
      handler: function (val) {
        this.$emit('on-changed', val);
      },
      deep: true
    }
  },

  created: function () {
    this.form = JSON.parse(JSON.stringify(this.module));
  },

  methods: {
    itemShow(index) {
      this.form.images.find((e, key) => {if (index != key) return e.show = false});
      this.form.images[index].show = !this.form.images[index].show;
    },
  }
});
</script>

@push('footer-script')
  <script>
    register = @json($register);


    register.make = {
      style: {
        background_color: ''
      },
      floor: languagesFill(''),
      images: [
        {
          image: languagesFill('https://via.placeholder.com/760x500/eeeeee'),
          show: true,
          link: {
            type: 'product',
            value:''
          }
        },
        {
          image: languagesFill('https://via.placeholder.com/760x240/eeeeee'),
          show: false,
          link: {
            type: 'product',
            value:''
          }
        },
        {
          image: languagesFill('https://via.placeholder.com/760x240/eeeeee'),
          show: false,
          link: {
            type: 'product',
            value:''
          }
        },
      ]
    }

    app.source.modules.push(register)
  </script>
@endpush
