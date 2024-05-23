<template>
  <Navbar></Navbar>
  <main>
    <h1>This is Unauthenticated Layout</h1>
    <router-view></router-view>
  </main>
</template>
<script setup>
import Navbar from "./Navbar.vue";
</script>
