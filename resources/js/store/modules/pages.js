import * as types from '../mutation-types'

// state
export const state = {
  list: {}
}

// getters
export const getters = {
  list: state => state.list
}

// mutations
export const mutations = {
  [types.ADD_PAGE] (state, pageObj) {
    state.list = {
      ...pageObj,
      ...state.list
    }
  }
}

// actions
export const actions = {
  addPage ({ commit }, pageObj ) {
    commit( types.ADD_PAGE, pageObj )
  }
}