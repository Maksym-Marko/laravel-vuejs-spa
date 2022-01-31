import * as types from '../mutation-types'

// state
export const state = {
  list: []
}

// getters
export const getters = {
  list: state => state.list
}

// mutations
export const mutations = {
  [types.SET_NEWS] (state, { list }) {
    state.list = list
  }
}

// actions
export const actions = {
  setNews ({ commit }, { list }) {
    commit(types.SET_NEWS, { list })
  }
}