<template>
  <img alt="Vue logo" src="./assets/logo.png">
  <Login />
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import Login from './components/Login.vue';

@Options({
  components: {
    Login,
  },
})
export default class App extends Vue {}
</script>