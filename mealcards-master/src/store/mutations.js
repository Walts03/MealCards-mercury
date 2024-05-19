// mutations.js
export default {
  setSearchedMeals(state, meals) {
    state.searchedMeals = meals || [];
  },
  setMealsByLetter(state, meals) {
    state.mealsByLetter = meals || [];
  },
  setMealsByIngredient(state, meals) {
    state.mealsByIngredient = meals || [];
  },
  setCurrentPage(state, page) {
    state.pagination.currentPage = page;
  },
  setTotalItems(state, totalItems) {
    state.pagination.totalItems = totalItems;
  },
  setUser(state, user) {
    state.user = user;
    if (user) {
      localStorage.setItem("user", JSON.stringify(user));
    } else {
      localStorage.removeItem("user");
    }
  },
  SET_FAVORITES(state, favorites) {
    state.favoriteMeals = favorites;
  },
  ADD_FAVORITE(state, mealId) {
    state.favoriteMeals.push(mealId);
  },
  REMOVE_FAVORITE(state, mealId) {
    state.favoriteMeals = state.favoriteMeals.filter((id) => id !== mealId);
  },
  SET_FAVORITE_MEALS_DETAILS(state, meals) {
    meals.forEach((meal) => {
      state.mealDetails[meal.idMeal] = meal;
    });
  },
};
