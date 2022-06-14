<template>
    <div class="content-box">
        <h2 class="content-box-header" style="height: 60px; background-color: #37769e; font-size: 24px;">
            <span style="color: white;">USERS</span>
            <div class="col-md-3 pull-right">
                <button
					v-if="checkPermission('add')"
                    data-toggle="modal"
					data-target="#create-user-modal"
					data-backdrop="static"
					data-keyboard="false"
                    class="btn btn-sm btn-block btn-default">
                    <i class="glyph-icon icon-plus"></i>
                    &nbsp;&nbsp;&nbsp;
                    Create New User
                </button>
            </div>
        </h2>
        <div class="panel-body">
            <div id="search-table" class="content-box-wrapper scroll-columns pad0A">
				<transition name="fade">
					<div class="alert alert-warning mrg10T" v-if="!users.length">
						<div class="bg-orange alert-icon">
							<i class="glyph-icon icon-warning"></i>
						</div>
						<div class="alert-content">
							<h4 class="alert-title">Warning</h4>
							<p>No Users to show!</p>
						</div>
					</div>			
				</transition>
				<transition name="fade">
					<table v-if="users.length && checkPermission('view')" class="table table-hover table-condensed" cellspacing="0" style="margin-top:10px;">
						<thead style="background-color: #f9fafe; color: #4b5056;">
							<tr style="height: 30px; font-size: 12px; font-weight: bold;">
								<th>Email</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Role</th>
								<th>Created At</th>
								<th>Updated At</th>
								<th style="text-align: center;">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(u, index) in users" style="font-size: 13px;" :key="index">
								<td>{{u.email}}</td>
								<td>{{u.first_name}}</td>
								<td>{{u.last_name}}</td>
								<td>{{u.role}}</td>
								<td>{{u.created_at}}</td>
								<td>{{u.updated_at}}</td>
								<td style="text-align: center;">
									<a 	v-if="checkPermission('edit')"
										class="btn btn-sm"
										title="Edit User"
										data-toggle="modal"
										data-target="#update-user-modal"
										data-backdrop="static"
										data-keyboard="false"
										v-on:click="updateThisUser(u)">
										<i class="glyph-icon icon-pencil"></i>
									</a>
									<a  v-if="checkPermission('delete')"
										class="btn btn-sm"
										title="Delete User"
										data-toggle="modal"
										data-target="#delete-user-modal"
										data-backdrop="static"
										data-keyboard="false"
										v-on:click="updateThisUser(u)">
										<i class="glyph-icon icon-trash"></i>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</transition>
			</div>
        </div>

		<!-- CREATE NEW USER MODAL -->
		<user-create
			:user-roles="userRoles"
			@refresh-users="refreshUsers">
		</user-create>

		<!-- UPDATE USER MODAL -->
		<user-update
			:user-roles="userRoles"
			:user="updateUserInfo"
			@refresh-users="refreshUsers">
		</user-update>

		<user-delete
			:user="updateUserInfo"
			@refresh-users="refreshUsers">
		</user-delete>
    </div>
</template>

<script>
	import axios from 'axios';

    export default {
        data () {
            return {
                users: users,
				userRoles: userRoles,
				permissions: permissions,

				updateUserInfo: {}
            }
        },
		methods:{
			updateThisUser(data){
				this.updateUserInfo = data;
			},
			checkPermission(type){
				for(var i in this.permissions)
					if(this.permissions.hasOwnProperty(i))
						if(type == i && this.permissions[i])
							return true;

				return false;
			},
			refreshUsers(){
                axios.get('get-all-users')
                .then((response) => {
                    this.users = response.data;                 
                })
                .catch( error => {
					
                });
			}
		}
    }
</script>