<template>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1 class="panel-title">{{ quiz.title }}</h1>
        <h4>{{ questions[current].title }}</h4>
      </div>

      <div class="panel-body">
        <el-form v-model="questions[current]" :rules="rules" ref="question">

          <el-form-item :label="questions[current].title" prop="question">
            <el-radio-group v-model="questions[current].answer_id">
              <el-radio v-for="(answer, key) in questions[current].answers" @change="getIndex(key)" @click="getIndex(key)" :key="key" :label="answer.title"></el-radio>
            </el-radio-group>
          </el-form-item>

          <el-progress :percentage="progress"></el-progress>

          <el-button type="primary" @click="goToNextQuestion" :disabled="questions.length === answeredQuestions.length">Next</el-button>
        </el-form>
      </div>
    </div>
    <div class="block block-result" v-if="results">
      <Result :message="message" :username="username" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    quiz: {
      type: Object,
      required: true,
      default: {
        quiz_id: null,
        title: null
      }
    },
    username: {
      type: String,
      required: true,
      default: null
    }
  },
  data() {
    return {
      index: 0,
      questions: [
        {
          id: null,
          title: null,
          question_id: null,
          quiz_id: null,
          answers: [
            {
              id: null,
              title: null,
              question_id: null,
              answer_id: null,
              quiz_id: null
            }
          ]
        }
      ],
      message: null,
      result: false,
      started: false,
      completed: false,
      current: 0,
      loading: false,
      saving: false,
      questionAnswered:false,
      answeredQuestions: [],
      progress: 0,
      results: false,
      rules: {
        answer_id: [
          { required: true, message: 'Please choose an answer', trigger: 'blur' },
        ],
      },
    }
  },
  mounted() {
    this.getData(this.quiz.quiz_id);
    window.onbeforeunload = function(){
       return "Are you sure you want to close the window?";
    }
  },
  created() {
    // this.quiz_id = this.$router.params.id;
    this.goToNextQuestion();
  },
  methods: {
    getData(id) {
      if (id === null) {
        return;
      }
      this.$http.get('/question/browse/'+id, {
        headers: { 'Accept': 'application/json' },
      }).then(response => {
        this.questions = response.data
      }, function(error) {
        console.log(error)
      })
    },
    getIndex(index) {
      this.index = index;
      this.questionAnswered = true;
    },
    goToNextQuestion() {
      if (this.questionAnswered === false && this.current != -1) {
        return;
      }

      // push answered question id
      this.answeredQuestions.push(this.questions[this.current].answers[this.index].answer_id);
      // increase progress bar width according to answered questions 
      this.progress = parseInt(this.answeredQuestions.length / this.questions.length * 100);
      // mark the answer checked
      this.questions[this.current].answers[this.index].checked = true; 
      // mark question answered and move to next one
      this.questionAnswered = false;
      // Move to the next question
      if (this.questions.length-1 > this.current) {
        this.current+=1;
      }

      if (this.current === this.questions.length-1) {
        this.saving = true;
        const headers = {headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}};
        const data = {
            id: this.quiz.quiz_id,
            answers: this.answeredQuestions,
            result: this.questions,
            quiz: this.quiz
        }
        this.$http.post('/quiz/result/save', data, headers).then( response => {           

          this.saving   = false;
          this.results  = true;

          this.message = "You responded correctly "+response.data.score+" out of "+this.questions.length+" questions";

        }, error => {
          this.saving = false;
        });
        // return;
      }

      this.loading = false;
    },
    saveAnswer() {
      return false;
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