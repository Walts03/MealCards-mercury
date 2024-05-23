<template>
  <div class="mt-20">
    <Meals :meals="meals" />
  </div>
</template>
<script setup>
import { computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import store from "../store";
import Meals from "../components/Meals.vue";
const route = useRoute();
const meals = computed(() => store.state.mealsByIngredient);
onMounted(() => {
  store.dispatch("searchMealsByIngredient", route.params.ingredient);
});
</script>
