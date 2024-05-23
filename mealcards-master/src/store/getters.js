// getters.js
export default {
  paginatedMeals(state) {
    const start =
      (state.pagination.currentPage - 1) * state.pagination.pageSize;
    const end = start + state.pagination.pageSize;
    return state.searchedMeals.slice(start, end);
  },
  totalItems(state) {
    return state.pagination.totalItems;
  },
  currentPage(state) {
    return state.pagination.currentPage;
  },
  isAuthenticated: (state) => !!state.user,
  isFavorite: (state) => (mealId) => {
    return state.favoriteMeals.includes(mealId);
  },
};
