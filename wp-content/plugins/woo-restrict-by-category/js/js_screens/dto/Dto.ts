export interface CategoryItem{
    slug:string;
    name:string;
}

export interface RoleOrUser{
    name:string;
    slug:string;
    currentPrivileges:string[];
}
