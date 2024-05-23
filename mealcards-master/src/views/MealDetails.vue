<template>
  <div class="max-w-[800px] mx-auto p-8 mt-20">
    <h1 class="text-5xl font-bold mb-5">{{ meal.strMeal }}</h1>
    <img :src="meal.strMealThumb" alt="meal.strMeal" class="max-w-[100%]" />
    <div class="grid grid-cols-1 sm:grid-cols-3 text-lg py-2">
      <div>
        <strong class="font-bold">Category: </strong>{{ meal.strCategory }}
      </div>
      <div><strong class="font-bold">Area: </strong>{{ meal.strArea }}</div>
      <div><strong class="font-bold">Tags: </strong>{{ meal.strTags }}</div>
    </div>

    <div class="mg-3">
      {{ meal.strInstructions }}
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2">
      <div>
        <h2 class="text-2xl font-semibold mb-2">Ingredients</h2>
        <ul>
          <template v-for="(el, ind) of new Array(20)">
            <li v-if="meal[`strIngredient${ind + 1}`]" v-bind:key="ind">
              {{ ind + 1 }}. {{ meal[`strIngredient${ind + 1}`] }}
            </li>
          </template>
        </ul>
      </div>
      <div>
        <h2 class="text-2xl font-semibold mb-2">Measures</h2>
        <ul>
          <template v-for="(el, ind) of new Array(20)">
            <li v-if="meal[`strMeasure${ind + 1}`]" v-bind:key="ind">
              {{ meal[`strMeasure${ind + 1}`] }}
            </li>
          </template>
        </ul>
      </div>
    </div>
    <div class="mt-4">
      <YoutubeButton :href="meal.strYoutube">Youtube</YoutubeButton>
      <button
        class="px-3 py-2 ml-2 text-white rounded border-2 border-lime-600 bg-lime-700 hover:bg-lime-800 hover:text-white transition-colors"
        @click="toggleFavorite(meal.idMeal)"
      >
        {{
          isFavorite(meal.idMeal) ? "Remove from Favorites" : "Add to Favorites"
        }}
      </button>
      <br /><br />
      <button
        v-if="isAuthenticated"
        class="px-3 py-2 text-white rounded border-2 border-blue-600 bg-blue-700 hover:bg-blue-800 hover:text-white transition-colors"
        @click="likeMeal(meal.idMeal)"
      >
        Like ({{ mealLikes.likes || 0 }})
      </button>
      <button
        v-if="isAuthenticated"
        class="px-3 py-2 ml-2 text-white rounded border-2 border-red-600 bg-red-700 hover:bg-red-800 hover:text-white transition-colors"
        @click="dislikeMeal(meal.idMeal)"
      >
        Dislike ({{ mealLikes.dislikes || 0 }})
      </button>

      <a
        v-if="meal.strSource !== null"
        :href="meal.strSource"
        target="_blank"
        class="inline-block ml-2 px-3 py-2 rounded border-2 border-transparent text-indigo-600 hover:bg-indigo-500 hover:text-white transition-colors"
      >
        View Original Source
      </a>
      <p
        v-else
        class="inline-block ml-3 px-3 py-2 rounded border-2 border-transparent text-indigo-600"
      >
        Original Source not available
      </p>
    </div>
  </div>
</template>

<script setup>
import axiosClient from "../axiosClient";
import { useRoute } from "vue-router";
import { onMounted, ref, computed } from "vue";
import YoutubeButton from "../components/YoutubeButton.vue";
import { useStore } from "vuex";

const route = useRoute();
const meal = ref({});
onMounted(() => {
  axiosClient.get(`lookup.php?i=${route.params.id}`).then(({ data }) => {
    meal.value = data.meals[0] || {};
  });
});

// Use Vuex store
const store = useStore();

// Map Vuex state and actions
const favoriteMeals = computed(() => store.state.favoriteMeals);
const isFavorite = (mealId) => favoriteMeals.value.includes(mealId);
const mealLikes = computed(
  () => store.state.mealDetails[meal.value.idMeal] || { likes: 0, dislikes: 0 }
);
const isAuthenticated = computed(() => store.getters.isAuthenticated);

// Methods
const toggleFavorite = (mealId) => {
  if (isFavorite(mealId)) {
    store.dispatch("deleteFavorite", mealId);
  } else {
    store.dispatch("addFavorite", mealId);
  }
};

const likeMeal = (mealId) => {
  store.dispatch("likeMeal", mealId);
};

const dislikeMeal = (mealId) => {
  store.dispatch("dislikeMeal", mealId);
};

// Fetch favorites and meal likes when component is mounted
onMounted(() => {
  store.dispatch("fetchFavorites");
  store.dispatch("fetchMealLikes", route.params.id);
});
</script>
