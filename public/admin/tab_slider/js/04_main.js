new Vue({
  el: '#appSlider',
  data: sliderState,
  methods: sliderMethods,
  mounted() {
    this.obtenerSliders();

    this.$nextTick(() => {
      this.activarDrag();

      $('#snCrearDescripcion').summernote({
        height: 150
      });

      $('#snEditarDescripcion').summernote({
        height: 150
      });
    });
  }
});