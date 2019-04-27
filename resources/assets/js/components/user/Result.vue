<template>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1 class="panel-title">Thanks, {{ username }}</h1>
        <h4>{{ message }}</h4>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true,
      default: null
    },
    username: {
      type: String,
      required: true,
      default: null
    }
  },
  data() {
    return {
      data: null
    }
  },
  mounted() {

  },
  created() {

  },
  methods: {

  }
}
</script>
<style type="text/css" lang="scss">
  h1 {
    text-align: center;
  }
  .el-select {
    margin: 0 auto;
  }
</style>