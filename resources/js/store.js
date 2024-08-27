import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isAuthenticated: !!localStorage.getItem('token'),
    isType: localStorage.getItem('datamis'),
    roles: localStorage.getItem('roles'),
    level: localStorage.getItem('level'),
    ability: localStorage.getItem('roles'),
    expire_time: localStorage.getItem('expire_time'),
    cheval_error: localStorage.getItem('cheval_error'),
    push_to_selling: localStorage.getItem('push_to_selling'),
    reject_driver: localStorage.getItem('reject_driver'),
  },

  getters: {
    isAuthenticated (state) {
      return state.isAuthenticated;
    },
    isType (state) {
      return state.isType;
    },
    isLevel (state) {
      return state.level;
    },
    getAbility (state) {
      return state.ability;
    },
    getExpireTime (state) {
      return state.expire_time;
    },

    getChevalError (state){
      return state.cheval_error;
    },

    getPushToSelling (state){
      return state.push_to_selling ? state.push_to_selling : 3;
    },
    getRejectDriver (state){
      return state.reject_driver ? state.reject_driver : 3;
    },

    user(state) {
      if (!state.isAuthenticated) {
        return false;
      }
      if (!state.isType) {
        return null;
      }

      return JSON.parse(localStorage.getItem('user'));
    }
  },

  mutations: {
    authenticate (state, payload) {
      state.isAuthenticated = true;
      state.isType = payload.info.type;

      localStorage.setItem('token',           payload.token);
      localStorage.setItem('datamis',         payload.info.type);
      localStorage.setItem('roles',           payload.info.roles);
      localStorage.setItem('push_to_selling', parseInt(payload.info.push_to_selling));
      localStorage.setItem('reject_driver',   parseInt(payload.info.reject_driver));
      localStorage.setItem('level',           parseInt(payload.info.level));
      localStorage.setItem('expire_time',     payload.expire_time);
      localStorage.setItem('user',            JSON.stringify(payload.info));
      Vue.set(state, "token", parseInt(payload.token));
      Vue.set(state, "datamis", parseInt(payload.info.type));
      Vue.set(state, "roles", parseInt(payload.info.roles));
      Vue.set(state, "level", parseInt(payload.info.level));
      Vue.set(state, "expire_time", parseInt(payload.expire_time));
      Vue.set(state, "user", parseInt(payload.info));
      Vue.set(state, "push_to_selling", parseInt(payload.info.push_to_selling));
      Vue.set(state, "reject_driver", parseInt(payload.info.reject_driver));
    },

    updateUser (state, payload) {
      
      state.isType = payload.info.type;
      localStorage.setItem('token',           payload.token);
      localStorage.setItem('expire_time',     payload.expire_time);
      localStorage.setItem('push_to_selling', payload.info.push_to_selling);
      localStorage.setItem('reject_driver',   payload.info.reject_driver);
      localStorage.setItem('user',            JSON.stringify(payload.info));
      
      Vue.set(state, "token", parseInt(payload.token));
      Vue.set(state, "expire_time", parseInt(payload.expire_time));
      Vue.set(state, "user", parseInt(payload.info));
      Vue.set(state, "push_to_selling", parseInt(payload.info.push_to_selling));
      Vue.set(state, "reject_driver", parseInt(payload.info.reject_driver));
    },

    logout(state) {
      state.isAuthenticated = false;
      state.isType = null;
      localStorage.removeItem('token');
      localStorage.removeItem('datamis');
      localStorage.removeItem('roles');
      localStorage.removeItem('level');
      localStorage.removeItem('user');
      localStorage.removeItem('expire_time');
      localStorage.removeItem('push_to_selling');
      localStorage.removeItem('reject_driver');

      Vue.delete(state,'token');
      Vue.delete(state,'datamis');
      Vue.delete(state,'roles');
      Vue.delete(state,'level');
      Vue.delete(state,'user');
      Vue.delete(state,'expire_time');
      Vue.delete(state,'push_to_selling');
      Vue.delete(state,'reject_driver');
    },

    insertError (state, payload) {
      localStorage.setItem('cheval_error',         payload);
      state.cheval_error = localStorage.getItem('cheval_error')
    },

    updateError (state, payload) {
      localStorage.setItem('cheval_error',         payload);
      state.cheval_error = localStorage.getItem('cheval_error')
    },

    deleteError (state) {
      localStorage.removeItem('cheval_error');
      state.cheval_error = localStorage.getItem('cheval_error')
    },
  },

  actions: {

    login (context, payload) {
      context.commit('authenticate', payload);
    },

    updateUser (context, payload) {
      context.commit('updateUser', payload);
    },

    logout (context) {
      context.commit('deleteError');
      context.commit('logout');
    },

    insertError(context,payload){
      console.error("Insert",payload)
      context.commit('insertError', payload);
    },
    updateError(context,payload){
      console.error("Update",payload)
      context.commit('updateError', payload);
    },
    deleteError(context){
      context.commit('deleteError');
    },

  }
})
