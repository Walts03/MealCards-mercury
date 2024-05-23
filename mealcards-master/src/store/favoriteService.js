import axios from "axios";
const API_URL =
  "https://mercury.swin.edu.au/cos30043/s103808977/hd/resources/favorites.php";

export const addFavorite = (userId, mealId) => {
  return axios.post(API_URL, { userId, mealId });
};

export const deleteFavorite = (userId, mealId) => {
  return axios.delete(API_URL, { data: { userId, mealId } });
};

export const getFavorites = (userId) => {
  return axios.get(API_URL, { params: { userId } });
};
