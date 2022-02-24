import * as types from '../mutation-types'

// state
export const state = {
  show: false,
  message: ''
}

// getters
export const getters = {
  show: state => state.show,
  message: state => state.message  
}

// mutations
export const mutations = {
  [types.NOTIFY] (state, { show, message }) {
    state.show    = true
    state.message = message

    setTimeout( () => {

      state.show  = false
      
    }, 2000 )
  }
}

// actions
export const actions = {
  notify ({ commit }, { show, message }) {
    commit(types.NOTIFY, { show, message })
  }
}