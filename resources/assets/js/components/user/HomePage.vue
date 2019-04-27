<template>
  <div>
    <div class="row block block-quiz">
      <div class="container">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="panel-title">Technical Task</h1>
          </div>

          <div class="panel-body">
            <el-form v-bind:model="form" :rules="rules" ref="form">
                <el-form-item prop="name">
                  <el-input placeholder="Enter your name" name="name" required v-model="form.name"></el-input>
                </el-form-item>

                <el-form-item prop="quiz_id">
                  <el-select v-model="form.quiz_id" filterable placeholder="Choose test">
                    <el-option v-for="(option, key) in quizzes" :key="key" :label="option.title" :value="option.quiz_id"></el-option>
                  </el-select>
                </el-form-item>

                <el-button type="primary" @click="submitForm('form')">Start</el-button>
            </el-form>
          </div>
        </div>
      </div>
    </div>
    <div class="row block block-question" v-if="show">
      <Quiz :quiz="quiz" :username="form.name" />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false, // toggles the quiz component visibiity
      // Quiz data structure
      quizzes: [
        {
          id: null,
          title: null,
          quiz_id: null
        }
      ],
      // Form fields
      form: {
        name: null,
        quiz_id: null,
      },
      // rules for form fields
      rules: {
        name: [
          { required: true, type: 'string', message: 'Please enter your name', trigger: 'blur' },
        ],
        quiz_id: [
          { required: true, message: 'Please select a test', trigger: 'change' },
        ],
      },
    }
  },
  mounted() {
    // Fetch the quizzes data when the component is mounted
    this.getData();
  },
  created() {

  },
  watch: {
    'form.quiz_id'() {
      this.quiz = this.quizzes.find(x => x.quiz_id === this.form.quiz_id);
    }
  },
  methods: {
    getData() {
      this.$http.get('/quiz/browse', {
        headers: { 'Accept': 'application/json' },
      }).then(response => {
        // console.log(response);
        this.quizzes = response.data
      }, error => {
        console.log(error)
      })
    },
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.show = true;
          // this.$router.push({name: 'QuizPage', params:{ id: this.form.quiz_id }});
        } else {
          this.$swal('Please fill the form')
          return false
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    }
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