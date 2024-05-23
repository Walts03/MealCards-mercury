import axios from "axios";
const API_URL =
  "https://mercury.swin.edu.au/cos30043/s103808977/hd/resources/vote.php";

export const likeMeal = (userId, mealId) => {
  return axios.post(API_URL, {
    user_id: userId,
    meal_id: mealId,
    action: "like",
  });
};

export const dislikeMeal = (userId, mealId) => {
  return axios.post(API_URL, {
    user_id: userId,
    meal_id: mealId,
    action: "dislike",
  });
};

export const getMealLikes = (mealId) => {
  return axios.get(API_URL, { params: { meal_id: mealId } });
};
