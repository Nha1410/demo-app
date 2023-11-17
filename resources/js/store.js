import { createStore } from 'vuex'

const store = createStore({
    state () {
      return {
        count: 0,
        userOptions: [],
      }
    },
    mutations: {
        increment (state) {
            state.count++
        },
        setOptions(state, userOptionsLoaded) {
            state.userOptions = userOptionsLoaded.data;
        },
    },
    actions: {
        async loadUserOptions({commit}) {
            try {
                const response = await axios.get(route('user.get-options'));
                const userOptionsLoaded = response;
                commit("setOptions", userOptionsLoaded);
            } catch (error) {
                console.error('Error loading user option', error);
            }
        }
    }
  })

export default store;
