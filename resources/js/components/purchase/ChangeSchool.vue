<template>
  <div>
    学校名:
    <select @change="selectSchool()">
      <option v-for="(item, index) in schoolsList" :key="index">
        {{ item.name }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: 'ChangeSchool',
  props: ['schoolsList'],
  data: function() {
    return {
    }
  },
  methods: {
    // 学校の変更
    selectSchool: function() {
      for(var i = 0; i < this.schoolsList.length; i++) {
        if(event.target.value === this.schoolsList[i].name) {
          this.$emit('selectSchool', this.schoolsList[i].id)
          return
        }
      }
    }
  }
}
</script>