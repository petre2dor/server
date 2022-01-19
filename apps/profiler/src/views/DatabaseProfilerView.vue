<template>
	<div>
		<h1>Database queries {{ $route.params.token }}</h1>
		<table>
			<thead>
				<tr>
					<th class="nowrap" style="cursor: pointer;">#<span class="text-muted">▲</span></th>
					<th class="nowrap" style="cursor: pointer;">Time<span></span></th>
					<th style="width: 100%;">Info</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(query, index) in queries" :v-key="query.sql">
					<td>
						{{ index }}
					</td>
					<td>
						{{ query.executionMS }} ms
					</td>
					<td>
						<pre>
{{ query.sql }}
						</pre>
						<h4>Parameters:</h4>
						{{ query.params }}
					</td>

				</tr>
			</tbody>
		</table>
		<ul>
			</li>
		</ul>
	</div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
export default {
	name: 'DatabaseProfilerView',
	computed: {
		queries() {
			if (this.loading) {
				return []
			}
			return this.profiles[this.$route.params.token]?.collectors.db.queries.default
		},
		...mapGetters(['profile']),
		...mapState(['profiles', 'loading']),
	},
}
</script>

<style lang="scss" scoped>
table {
	background: var(--color-background-darker);
	border: var(--border-color-dark);
	box-shadow: rgba(32, 32, 32, 0.2) 0px 0px 1px 0px;
	margin: 1em 0;
	width: 100%;
}
table, tr, th, td {
	background: var(--table-background);
	border-collapse: collapse;
	line-height: 1.5;
	vertical-align: top !important;
}

thead tr {
	background: var(--color-background-dark);
}

table th, table td {
	padding: 8px 10px;
}

table tbody th, table tbody td {
	border: 1px solid #ddd;
	border-width: 1px 0;
	font-family: monospace;
	font-size: 13px;
}

.nowrap {
	white-space: nowrap;
}

tbody tr:hover, tbody tr:focus, tbody tr:active {
	background-color: inherit;
}
</style>
