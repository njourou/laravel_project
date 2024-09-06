<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style>
/* Apply Montserrat font */
body {
  font-family: 'Montserrat', sans-serif;
  margin: 0; /* Remove default margin */
  height: 100vh; /* Full viewport height */
}

#app {
  display: flex;
  justify-content: center; /* Center horizontally */
  align-items: center; /* Center vertically */
  color: #2c3e50;
  height: 100%;
}
</style>
