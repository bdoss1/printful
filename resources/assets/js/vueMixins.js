Vue.mixin({
  methods: {
    followRoute(name = null, id = null) {
      if (name != null && id != null) {
        return this.$router.push({ name: name, params: { id: id }})
      } else if (name != null) {
        return this.$router.push({ name: name })
      }
    },
    returnFormState() {
      return { '$dirty': false, '$pristine': true, '$valid': false, '$invalid': true, '$submitted': false, '$touched': false, '$untouched': true,
        '$focused': false, '$pending': false, '$error': {}, '$submittedState': {},
        'name': { '$name': 'name', '$dirty': false, '$pristine': true, '$valid': false, '$invalid': true,
          '$touched': false, '$untouched': true, '$focused': false, '$pending': false, '$error': { 'required': true }},
        'email': { '$name': 'email', '$dirty': false, '$pristine': true, '$valid': false, '$invalid': true, '$touched': false,
          '$untouched': true, '$focused': false, '$pending': false, '$error': { 'email': true }
        }
      }
    },
    Headers() {
      return { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }}
    },
    fieldClassName(field) {
      if (!field) {
        return ''
      }
      if ((field.$touched || field.$submitted) && field.$valid) {
        return 'has-success'
      }
      if ((field.$touched || field.$submitted) && field.$invalid) {
        return 'has-danger'
      }
    },
    defaultImage() {
      return 'https://semantic-ui.com/images/wireframe/image.png'
    },
    in_array(needle, haystack) {
      if (haystack.includes(needle)) {
        return true
      }
      return false
    }
  }
})
