<template>
    <div class="content-box">
        <h2 class="content-box-header" style="height: 60px; background-color: #37769e; font-size: 24px;">
            <span style="color: white;">ROLES</span>
            <div class="col-md-3 pull-right">
                <button
					v-if="checkPermission('add')"
                    data-toggle="modal"
					data-target="#create-role-modal"
					data-backdrop="static"
					data-keyboard="false"
                    class="btn btn-sm btn-block btn-default">
                    <i class="glyph-icon icon-plus"></i>
                    &nbsp;&nbsp;&nbsp;
                    Create New Role
                </button>
            </div>
        </h2>
        <div class="panel-body">
            <div id="search-table" class="content-box-wrapper scroll-columns pad0A">
				<transition name="fade">
					<div class="alert alert-warning mrg10T" v-if="!roles.length">
						<div class="bg-orange alert-icon">
							<i class="glyph-icon icon-warning"></i>
						</div>
						<div class="alert-content">
							<h4 class="alert-title">Warning</h4>
							<p>No Roles to show!</p>
						</div>
					</div>			
				</transition>
				<transition name="fade">
					<table v-if="roles.length && checkPermission('view')" class="table table-hover table-condensed" cellspacing="0" style="margin-top:10px;">
						<thead style="background-color: #f9fafe; color: #4b5056;">
							<tr style="height: 30px; font-size: 12px; font-weight: bold;">
								<th>Role Name</th>
								<th>Role Code</th>
								<th style="text-align: center;">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(u, index) in roles" style="font-size: 13px;" :key="index">
								<td>{{u.name}}</td>
								<td>{{u.code}}</td>
								<td style="text-align: center;">
									<a 	v-if="checkPermission('edit')"
										class="btn btn-sm"
										title="Edit Role"
										data-toggle="modal"
										data-target="#update-role-modal"
										data-backdrop="static"
										data-keyboard="false"
										v-on:click="getRoleModulesPermissions(u.id)">
										<i class="glyph-icon icon-pencil"></i>
									</a>
									<a  v-if="checkPermission('delete')"
										class="btn btn-sm"
										title="Delete Role"
										data-toggle="modal"
										data-target="#delete-user-modal"
										data-backdrop="static"
										data-keyboard="false">
										<i class="glyph-icon icon-trash"></i>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</transition>
			</div>
        </div>

		<!-- UPDATE ROLE MODAL -->
		<role-update
			:role-data="roleData"
			:modules="modules">
		</role-update>
    </div>
</template>

<script>
	import axios from 'axios';
	
    export default {
        data () {
            return {
                roles: roles,
				permissions: permissions,
				modules: [],
				roleData: []
            }
        },
		methods:{
			checkPermission(type){
				for(var i in this.permissions)
					if(this.permissions.hasOwnProperty(i))
						if(type == i && this.permissions[i])
							return true;

				return false;
			},
			getRoleModulesPermissions(id){
				axios.get('get-role-modules-permissions/'+id)
                .then((response) => {
                    this.roleData = response.data.roleData;
					this.modules  = response.data.modules;

					for(var i in this.modules)
						for(var o in this.roleData['modules'])
							if(this.modules[i].id == this.roleData['modules'][o].module_id){
								this.modules[i].is_selected = true;
								this.modules[i].user_role_modules_id = this.roleData['modules'][o].id;
							}

					for(var i in this.modules)
						for(var o in this.roleData['permissions'])
							if(this.modules[i].id == this.roleData['permissions'][o].module_id){
								this.modules[i].user_role_permissions_id = this.roleData['permissions'][o].id;
								this.modules[i].view = this.roleData['permissions'][o].view;
								this.modules[i].add = this.roleData['permissions'][o].add;
								this.modules[i].edit = this.roleData['permissions'][o].edit;
								this.modules[i].delete = this.roleData['permissions'][o].delete;
							}
                })
                .catch( error => {
					  
                });
			}
		}
    }
</script>