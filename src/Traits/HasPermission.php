<?php
namespace KjmTrue\Acl\Traits;

trait HasPermission
{
    protected $permissions = [];

    public function hasPermissionTo($permission)
    {
        $permissions = $this->getPermissions();

        return in_array($permission, $permissions);
    }

    protected function getPermissions()
    {
        if (! $this->permissions) {
            if ($this->role) {
                $permissions = (array) json_decode($this->role->permissions);

                foreach ($permissions as $key => $permission) {
                    if ($permission) {
                        $this->permissions[] = $key;
                    }
                }
            }

            $this->permissions = array_unique($this->permissions);
        }

        return $this->permissions;
    }
}