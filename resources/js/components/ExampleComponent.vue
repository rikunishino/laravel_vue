<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                    <ul>
                        <li v-for="(subject, index) in subjects" :key="index">{{ subject.name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        users: [],
        subjects: []
      }
    },
    mounted() {
        // axios.get('/users').then(response => this.users = response.data)
        axios.get('/subject')
          .then(response => {
            this.subjects = response.data
          })
        console.log('ccc')
    }
  }
</script>
