<template>
	<div id="profiler" class="content">
		<AppNavigation>
			<template #list>
				<AppNavigationCaption
					title="Categories" />
				<AppNavigationItem v-for="category in profilerCategories"
					:active="selectedCategory === category"
					:title="category"
					icon="icon-group" />

				<AppNavigationCaption
					title="Requests" />
				<div class="select-container">
					<Multiselect v-model="selectedProfile"
						:options="profiles"
						class="select"
						label="token"
						track-by="token" />
				</div>
			</template>
		</AppNavigation>
		<AppContent>
			<ProfileHeader :profile="selectedProfile" />
			<div class="router-wrapper">
				<router-view />
			</div>
		</AppContent>
	</div>
</template>

<script>
import { loadState } from '@nextcloud/initial-state'
import { AppNavigation, AppNavigationItem, AppContent, AppNavigationCaption, Multiselect } from '@nextcloud/vue'
import ProfileHeader from './components/ProfileHeader'

const profiles = loadState('profiler', 'profiles')
const profilerCategories = loadState('profiler', 'profiler-categories')

export default {
	name: 'Profiler',
	components: {
		AppNavigation,
		AppNavigationItem,
		AppContent,
		AppNavigationCaption,
		Multiselect,
		ProfileHeader
	},
	data() {
		const selectedProfile = profiles[0]
		const selectedCategory = profilerCategories[0]

		return {
			profiles,
			profilerCategories,
			selectedProfile,
			selectedCategory,
		}
	},
	watch: {
		selectedProfile(newToken) {
			this.$store.dispatch('loadProfile', { token: newToken.token })
			this.$router.push({ name: this.selectedCategory, params: { token: newToken.token } })
		},
	},
	mounted() {
		this.$store.dispatch('loadProfile', { token: this.selectedProfile.token })
		this.$router.push({ name: 'db', params: { token: this.selectedProfile.token } })
	},
}
</script>

<style lang="scss" scoped>
.select-container {
	padding: 0 .5rem;

	.multiselect {
		width: 100%
	}
}
.content {
	height: 100%;
	box-sizing: border-box;
	display: flex;
	min-height: 100%;
	width: 100%;
}
.router-wrapper {
	padding: 2rem;
}
</style>
