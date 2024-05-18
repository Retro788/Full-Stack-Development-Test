import {createStore} from "vuex";
import state from './state'
import * as actions from './actions'
import * as mutations from './mutation'

const store = createStore({
  state,
  getters: {},
  actions,
  mutations,
})

export default store