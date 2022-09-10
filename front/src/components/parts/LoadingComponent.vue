<template>
  <div id="loading" v-if="isLoading">
    <v-progress-circular
      :size="100"
      color="amber"
      indeterminate
    />
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
  background-color: #fff;
  opacity: 1;
}
</style>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'LoadingComponent',
  props: {
    isLoading: {
      type: Boolean,
      default: false
    }
  }
})
</script>