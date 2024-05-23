import { addFavorite, deleteFavorite, getFavorites } from "./favoriteService";
import { likeMeal, dislikeMeal, getMealLikes } from "./voteService";
import axiosClient from "../axiosClient";
export default {
  // existing actions...
  async searchMeals({ commit }, keyword) {
    if (!keyword) return; // Prevent empty queries
    try {
      const { data } = await axiosClient.get(`search.php?s=${keyword}`);
      commit("setSearchedMeals", data.meals);
      commit("setTotalItems", data.meals ? data.meals.length : 0);
    } catch (error) {
      console.error("Error fetching meals:", error);
      commit("setSearchedMeals", []); // Clear meals on error
      commit("setTotalItems", 0);
    }
  },
  async searchMealsByLetter({ commit }, letter) {
    try {
      const { data } = await axiosClient.get(`search.php?f=${letter}`);
      commit("setMealsByLetter", data.meals);
    } catch (error) {
      console.error("Error fetching meals by letter:", error);
      commit("setMealsByLetter", []);
    }
  },
  async searchMealsByIngredient({ commit }, ing) {
    try {
      const { data } = await axiosClient.get(`filter.php?i=${ing}`);
      commit("setMealsByIngredient", data.meals);
    } catch (error) {
      console.error("Error fetching meals by ingredient:", error);
      commit("setMealsByIngredient", []);
    }
  },
  login({ commit }, user) {
    return new Promise((resolve) => {
      commit("setUser", user);
      resolve();
    });
  },
  logout({ commit }) {
    return new Promise((resolve) => {
      localStorage.removeItem("user");
      commit("setUser", null);
      resolve();
    });
  },
  async fetchFavorites({ commit, state }) {
    if (state.user) {
      const response = await getFavorites(state.user.id);
      commit("SET_FAVORITES", response.data);
    }
  },
  async addFavorite({ commit, state }, mealId) {
    if (state.user) {
      await addFavorite(state.user.id, mealId);
      commit("ADD_FAVORITE", mealId);
    }
  },
  async deleteFavorite({ commit, state }, mealId) {
    if (state.user) {
      await deleteFavorite(state.user.id, mealId);
      commit("REMOVE_FAVORITE", mealId);
    }
  },
  async fetchMealDetails({ commit }, mealId) {
    const { data } = await axiosClient.get(`lookup.php?i=${mealId}`);
    if (data && data.meals && data.meals[0] && data.meals[0].idMeal) {
      commit("SET_FAVORITE_MEALS_DETAILS", [data.meals[0]]);
    }
  },
  async likeMeal({ commit, state }, mealId) {
    try {
      const userId = state.user.id;
      const response = await likeMeal(userId, mealId);
      if (response.data.success) {
        commit("SET_MEAL_LIKES", {
          mealId,
          likes: response.data.data.likes,
          dislikes: response.data.data.dislikes,
        });
      }
      return response.data;
    } catch (error) {
      console.error("Error liking meal", error);
    }
  },
  async dislikeMeal({ commit, state }, mealId) {
    try {
      const userId = state.user.id;
      const response = await dislikeMeal(userId, mealId);
      if (response.data.success) {
        commit("SET_MEAL_LIKES", {
          mealId,
          likes: response.data.data.likes,
          dislikes: response.data.data.dislikes,
        });
      }
      return response.data;
    } catch (error) {
      console.error("Error disliking meal", error);
    }
  },
  async fetchMealLikes({ commit }, mealId) {
    try {
      const response = await getMealLikes(mealId);
      if (response.data.success) {
        commit("SET_MEAL_LIKES", {
          mealId,
          likes: response.data.data.likes,
          dislikes: response.data.data.dislikes,
        });
      }
    } catch (error) {
      console.error("Error fetching meal likes", error);
    }
  },
};
