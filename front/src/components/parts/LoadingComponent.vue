<template>
  <div id="loading" v-if="isLoading">
    <v-progress-circular indeterminate />
  </div>
</template>

<style>
#loading {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100vh;
  z-index:9999;
  position: fixed;
  background-color: #fefefe;
  opacity: .5;
}
</style>

<script lang="ts">
import { defineComponent } from 'vue'
import { boolean } from 'yup';

export default defineComponent({
  name: 'LoadingComponent',
  props: {
    isLoading: {
      type: boolean,
      default: false
    }
  }
})
</script>