import { createStore } from 'vuex';

const store = createStore({
  state: {
    count: 0,
    user: null,
    popup_data : {
        message : '',
        class_show : 'hide'
    },
    userData : {
        token : localStorage.getItem('token') ? localStorage.getItem('token') : '',
        userDetail : localStorage.getItem('userDetail') ? JSON.parse(localStorage.getItem('userDetail')) : []
    },
    currentDate : new Date()
  },
  mutations: {
    increment(state) {
      state.count++;
    },
    setUser(state, user) {
      state.user = user;
    },
    setPopupData(state , popup_data){
        state.popup_data = popup_data
    },
    setUserData(state, userData){
        state.userData = userData
    }
  },
  actions: {
    increment(context) {
      context.commit('increment');
    },
    fetchUser({ commit }, userId) {
      // Misalnya, Anda ingin mengambil data pengguna dari API
      axios.get(`/api/users/${userId}`).then(response => {
        commit('setUser', response.data);
      });
    }
  },
  getters: {
    isAuthenticated(state) {
      return !!state.user;
    }
  }
});

export default store;
