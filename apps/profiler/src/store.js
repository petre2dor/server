import Vue from 'vue'
import Vuex, { Store } from 'vuex'
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

Vue.use(Vuex)

export default new Store({
	state: {
		profiles: {},
		loading: false,
	},
	mutations: {
		addProfile(state, { token, profile }) {
			state.profiles[token] = profile
		},
		setLoading(state, loading) {
			state.loading = loading
		},
	},
	getters: {
		profile: (state) => (token) => {
			return state.profiles[token]
		},
	},
	actions: {
		loadProfile({ commit, state }, { token }) {
			if (state.profiles[token]) {
				return
			}
			commit('setLoading', true)
			axios.get(generateUrl('/apps/profiler/profile/{token}', { token }))
				.then((response) => {
					commit('addProfile', { token, profile: response.data.profile })
					commit('setLoading', false)
				})
		},
	},
})
