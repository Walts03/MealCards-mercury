<template>
  <div class="bg-white shadow rounded-xl">
    <router-link :to="{ name: 'mealDetails', params: { id: meal.idMeal } }">
      <div class="relative flex items-end overflow-hidden rounded-xl"></div>
      <img
        :src="meal.strMealThumb"
        :alt="meal.strMeal"
        class="rounded-t-xl w-full h-48 object-cover"
      />
    </router-link>
    <div class="p-3">
      <h3 class="font-bold">{{ meal.strMeal }}</h3>
      <p class="mb-4">{{ meal.strArea }}</p>
      <YoutubeButton :href="meal.strYoutube">Youtube</YoutubeButton>
      <button
        v-if="isAuthenticated"
        class="px-3 py-2 ml-2 text-white rounded bg-lime-700 hover:bg-lime-800 hover:text-white transition-colors"
        @click="toggleFavorite(meal.idMeal)"
      >
        {{
          isFavorite(meal.idMeal) ? "Remove from Favorites" : "Add to Favorites"
        }}
      </button>
      <div class="mt-4">
        <button
          v-if="isAuthenticated"
          class="px-3 py-2 mr-2 text-white rounded bg-blue-700 hover:bg-blue-800 hover:text-white transition-colors"
          @click="likeMeal(meal.idMeal)"
        >
          Like ({{ mealLikes.likes || 0 }})
        </button>
        <button
          v-if="isAuthenticated"
          class="px-3 py-2 text-white rounded bg-red-700 hover:bg-red-800 hover:text-white transition-colors"
          @click="dislikeMeal(meal.idMeal)"
        >
          Dislike ({{ mealLikes.dislikes || 0 }})
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from "vue";
import { useStore } from "vuex";
import YoutubeButton from "../components/YoutubeButton.vue";

// Define props
const props = defineProps({
  meal: {
    required: true,
    type: Object,
  },
});

// Use Vuex store
const store = useStore();

// Map Vuex state and actions
const favoriteMeals = computed(() => store.state.favoriteMeals);
const isFavorite = (mealId) => favoriteMeals.value.includes(mealId);
const mealLikes = computed(
  () => store.state.mealDetails[props.meal.idMeal] || { likes: 0, dislikes: 0 }
);

// Methods
const toggleFavorite = (mealId) => {
  console.log("toggleFavorite called with", { mealId });
  if (isFavorite(mealId)) {
    store.dispatch("deleteFavorite", mealId);
  } else {
    store.dispatch("addFavorite", mealId);
  }
};
const isAuthenticated = computed(() => !!store.state.user);

// Voting methods
const likeMeal = (mealId) => {
  console.log("likeMeal called with", { mealId });
  store.dispatch("likeMeal", mealId).then(() => {
    store.dispatch("fetchMealLikes", mealId);
  });
};
const dislikeMeal = (mealId) => {
  console.log("dislikeMeal called with", { mealId });
  store.dispatch("dislikeMeal", mealId).then(() => {
    store.dispatch("fetchMealLikes", mealId);
  });
};

// Fetch favorites and meal likes when component is mounted
onMounted(() => {
  store.dispatch("fetchFavorites");
  store.dispatch("fetchMealLikes", props.meal.idMeal);
});
</script>
