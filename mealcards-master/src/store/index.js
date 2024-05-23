import { createStore } from "vuex";
import actions from "./actions";
import getters from "./getters";
import mutations from "./mutations";
import state from "./state";
const store = createStore({
  state,
  mutations,
  actions,
  getters,
});

export default store;
