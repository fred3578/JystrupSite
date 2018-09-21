import * as React from "react";

import Tabs from "react-bootstrap/lib/Tabs";
import Tab from "react-bootstrap/lib/Tab";
import Checkbox from "react-bootstrap/lib/Checkbox";
import {CategoryItem, RoleOrUser} from "../dto/Dto";
import * as Shuffle from "shufflejs";
import {ChangeEventHandler, FormEventHandler} from "react";
import shallowEqualFuzzy from "shallow-equal-fuzzy";

export class Privilege extends React.Component<PrivilegeProps,PrivilegeState>{

    constructor(){
        super();
        this.state={
            RoleOrUser:{
                name:'',
                slug:'',
                currentPrivileges:[]
            }
        }
    }

    render(): JSX.Element | any | any {
        return  (
            <div id={this.props.Id}  style={{maxWidth:300,display:'inline-block'}} className={"tabItem"} data-title={this.state.RoleOrUser.name}>
                <ul className="nav nav-tabs" style={{borderBottomStyle:'none'}}>
                    <li className="active"><a href="#">{this.state.RoleOrUser.name}</a></li>
                </ul>
                <div style={{border:"1px solid #ddd",padding:10,backgroundColor:"#ffffff"}}>

                    {this.props.Categories.length>0? this.props.Categories.map((category:CategoryItem)=>{
                        return ([
                            <div key={1} style={{display:'inline-block',marginBottom:5}}>
                                <Checkbox style={{display:'inline-block',margin:0}} value={category.slug} checked={this.state.RoleOrUser.currentPrivileges.some(x=>x==category.slug)} onChange={this.Changed.bind(this)}  >
                                    {category.name}
                                </Checkbox>

                            </div>,
                            <br key={2}/>

                        ])
                    }):
                        <div className={"alert alert-warning"}><h4><span className={"glyphicon glyphicon-warning-sign"}></span> No WooCommerce categories found</h4>Did you already installed WooCommerce?</div>
                    }
                </div>


            </div>
        )
    }

    componentDidMount(): void {
        let roleUser={...this.props.RoleOrUser};
        this.setState({
            RoleOrUser:roleUser
        })
    }

    componentWillReceiveProps(nextProps: Readonly<PrivilegeProps>, nextContext: any): void {
        if(!shallowEqualFuzzy(nextProps.RoleOrUser,this.props.RoleOrUser))
        {
            this.setState({
                RoleOrUser:nextProps.RoleOrUser
            })

        }
    }

    public Changed(event:any)
    {
        let newPrivileges={...this.state.RoleOrUser};
        let slug=event.target.value
        let checked=event.target.checked;
        if(checked)
        {
            if(!newPrivileges.currentPrivileges.some(x=>x==slug))
                newPrivileges.currentPrivileges.push(slug);

        }else{
            let index=newPrivileges.currentPrivileges.indexOf(slug);
            if(index>=0)
                newPrivileges.currentPrivileges.splice(index,1);
        }

        this.setState({RoleOrUser:newPrivileges})
        this.props.PrivilegeUpdated(newPrivileges);
    }


}

interface PrivilegeState{
    RoleOrUser:RoleOrUser;
}

interface PrivilegeProps{
    Categories:CategoryItem[];
    RoleOrUser:RoleOrUser;
    Id:string;
    PrivilegeUpdated:(roleOrUser:RoleOrUser)=>void;
}