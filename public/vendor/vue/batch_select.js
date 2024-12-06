
Vue.directive('batch-select', {


  componentUpdated: (el, binding) => {
    if (!app.isMultiple) {
      return;
    }

    el.style.position = 'relative';

    const { x, y } = el.getBoundingClientRect()
    const elPos = { x, y }



    const optionClassName = binding.value.className
    const options = [].slice.call(el.querySelectorAll(optionClassName))

    const optionsXYWH = []
    options.forEach(v => {
      const obj = v.getBoundingClientRect()
      optionsXYWH.push({
        x: obj.x - elPos.x,
        y: obj.y - elPos.y,
        w: obj.width,
        h: obj.height
      })
    })

    const area = document.createElement('div')
    area.style = 'position: absolute; border: 1px solid #409eff; background-color: rgba(64, 158, 255, 0.1); z-index: 10; visibility: hidden;'
    area.className = 'area'
    area.innerHTML = ''
    el.appendChild(area)
    el.onmousedown = (e) => {
      if (e.button !== 0) return
      let isContentCenter = false

      if (e.target.className === 'content-center') {

        binding.value.selectImageIndex.length = 0
        isContentCenter = true
      }


      const $image = $(e.target).parents('.image-list');


      const startX = e.clientX - elPos.x
      const startY = e.clientY - elPos.y

      let hasMove = false

      document.onmousemove = (e) => {
        if ($image.index() != -1 && !$image.hasClass('active')) {
          binding.value.selectImageIndex.length = 0
          app.checkedImage($image.index())
          binding.value.selectImageIndex.push($image.index())
        }

        hasMove = true
        binding.value.setSelectStatus(true)

        if (isContentCenter) {

          area.style.visibility = 'visible'

          const endX = e.clientX - elPos.x
          const endY = e.clientY - elPos.y

          const width = Math.abs(endX - startX)
          const height = Math.abs(endY - startY)

          const left = Math.min(startX, endX)
          const top = Math.min(startY, endY)

          area.style.left = `${left}px`
          area.style.top = `${top}px`
          area.style.width = `${width}px`
          area.style.height = `${height}px`
          const areaTop = parseInt(top)
          const areaRight = parseInt(left) + parseInt(width)
          const areaBottom = parseInt(top) + parseInt(height)
          const areaLeft = parseInt(left)
          binding.value.selectImageIndex.length = 0
          optionsXYWH.forEach((v, i) => {
            const optionTop = v.y
            const optionRight = v.x + v.w
            const optionBottom = v.y + v.h
            const optionLeft = v.x
            if (!(areaTop > optionBottom || areaRight < optionLeft || areaBottom < optionTop || areaLeft > optionRight)) {

              binding.value.selectImageIndex.push(i)
            }
          })
        } else {
          $('.select-tip').css({
            left: `${e.clientX + 10}px`,
            top: `${e.clientY + 10}px`,
            display: 'flex'
          })
        }
      }

      document.onmouseup = (e) => {
        document.onmousemove = document.onmouseup = null
        if (hasMove) {

          const { left, top, width, height } = area.style
          setTimeout(() => {
            binding.value.setSelectStatus(false)
          }, 100);
        }

        const [path, name] = [$(e.target).attr('path'), $(e.target).attr('name')]

        if (path) {
          binding.value.imgMove(path, name, binding.value.selectImageIndex)
        }

        $('.select-tip').hide().html('')

        hasMove = false
        isContentCenter = false
        area.style.visibility = 'hidden'
        area.style.left = 0
        area.style.top = 0
        area.style.width = 0
        area.style.height = 0
        return false
      }

      setTimeout(() => {
        const selectImages = binding.value.selectImageIndex.map(v => app.images[v])
        selectImages.forEach((v, i) => {
          $('.select-tip').append(`<div class="s-img">${v.mime == 'video/mp4' ? '<i class="el-icon-video-play""></i>' : '<img src=' + v.url + '></img>'}</div>`)
        })

        if (selectImages.length) {
          $('.select-tip').append(`<div class="quantity">${selectImages.length}</div>`)
        }
      }, 100);
    }
  },
  // update: (el, binding) => {}
})
