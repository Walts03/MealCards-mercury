<template>
  <div v-if="visible" :class="['notification', type]">
    <p>{{ message }}</p>
  </div>
</template>

<script setup>
import { ref, watchEffect } from "vue";

const props = defineProps({
  message: String,
  type: {
    type: String,
    default: "success", // success, error, info, etc.
  },
  duration: {
    type: Number,
    default: 2000, // Duration in milliseconds
  },
});

const visible = ref(true);

watchEffect(() => {
  if (props.message) {
    visible.value = true;
    setTimeout(() => {
      visible.value = false;
    }, props.duration);
  }
});
</script>

<style scoped>
.notification {
  position: fixed;
  bottom: 20px;
  right: 20px;
  padding: 10px 20px;
  border-radius: 5px;
  color: white;
  opacity: 0.9;
}
.notification.success {
  background-color: green;
}
.notification.error {
  background-color: red;
}
.notification.info {
  background-color: blue;
}
</style>
