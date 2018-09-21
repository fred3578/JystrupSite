import * as ReactDOM from "react-dom";
declare function spring(any);
declare let require:any;
import * as React from "react";
import LaddaButton from "react-ladda";
import SearchBox from "rednao-search-box";
import {Privilege} from "./Privilege";
import "../../../css/bootstrap-fix.css";
import "../../../css/mainApp.css";
import "../../../css/fontAwesome/css/font-awesome.css"
import {CategoryItem, RoleOrUser} from "../dto/Dto";
import * as Shuffle from "shufflejs";
import AsyncAjax, {CancellationToken} from "rednao-async-ajax";
import * as toastr from "rednao_toastr";
import "rednao_polyfill";

declare var ajaxurl:any;
declare var rednaoWcrbcParams:any;
class App extends React.Component<any,AppState>{


    public showUsers:boolean=false;
    public categories:CategoryItem[];
    public shuffle:Shuffle;
    public roleOrUsers:RoleOrUser[]=[];
    public executeSearchCancelToken:CancellationToken;
    constructor()
    {

        super();
        this.categories=rednaoWcrbcParams.categories;
        this.state={
            saving:false,
            filterString:'',
            loading:true

        }
        super();
    }


    componentDidMount(): void {
        this.InitializeShuffle();
        this.ExecuteSearch('');
    }

    private InitializeShuffle() {
        this.shuffle=new Shuffle(document.querySelector('.tabItemContainer'),{itemSelector:'.tabItem'});
        this.shuffle.sort({
            by:(element)=>{return element.getAttribute('data-title').toLowerCase();}
        })
    }

    async Saving(){
        this.setState({saving:true});
        let result=await AsyncAjax.Post<any>(ajaxurl,{action:'rednao_wcrbc_save_roles',data:JSON.stringify(this.roleOrUsers),type:'role'});
        if(result!=null&&result.success)
            toastr.success("Save Successfull!");
        else
            toastr.error("Sorry, the data couldn't be saved. Please try again.");
        this.setState({saving:false});
    }
/*{this.state.roleOrUsers.map((role: RoleOrUser) => {
                                        return <Privilege key={role.slug} Categories={this.categories}
                                                          RoleOrUser={role}></Privilege>
                                    })}*/

    render(): JSX.Element | any | any {
        return  <div style={{padding:10}} className={"bootstrap-wrapper"}>
                    <h1>{rednaoWcrbcParams.title}</h1>
                    <LaddaButton data-style="expand-right" loading={this.state.saving} onClick={this.Saving.bind(this)} className="btn btn-success"><span className="glyphicon glyphicon-floppy-disk"></span> Save</LaddaButton>
                    <SearchBox placeholder="Filter Roles" style={{width:300,float:'right'}}  onBoxKeyUp={(e)=>{this.ExecuteSearch(e)}}/>
                    <div className={"tabContainer"} style={{minHeight:300}}>
                        {[  <div key={1} className={"tabItemContainer"}>

                            </div>,
                            <div className={"backDrop "+(this.state.loading?"rednao_visible":"rednao_hidden")} key={"backDrop"} style={{backgroundColor:'#dfd', width:'100%',height:'100%',top:0,left:0,position:'absolute',opacity:.2}}>

                            </div>,
                            <div className={"loadingScreen "+(this.state.loading?"rednao_visible":"rednao_hidden")} key={"LoadingScreen"} style={{display:'flex',justifyContent:'center',alignItems:'center',flexDirection:'column', width:'100%',height:'100%',top:0,left:0,position:'absolute'}}>
                                <i className="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                                <span style={{fontSize:30}} >{rednaoWcrbcParams.loading_message}</span>
                            </div>
                            ]
                        }

                    </div>
                </div>

    }

    async ExecuteSearch(text: string) {
        this.setState({loading:true});
        if(this.executeSearchCancelToken!=null)
            this.executeSearchCancelToken.Cancel();
        let result=await AsyncAjax.CancellablePost<RoleOrUser[]>(ajaxurl,{action:rednaoWcrbcParams.search_action,searchTerm:text},this.executeSearchCancelToken=new CancellationToken());
        this.executeSearchCancelToken=null;
        if(result==null)
            result=[];
        let addedEllements=[];
        let removedElements=[];

        for(let existingRoles of this.roleOrUsers)
        {
            if(!result.some(x=>x.slug==existingRoles.slug))
                removedElements.push(existingRoles);
        }

        for(let newRoles of result)
        {
            if(!this.roleOrUsers.some(x=>x.slug==newRoles.slug))
                addedEllements.push(newRoles);
        }

        let itemContainer=document.querySelector('.tabItemContainer');
        let self=this;
        for(let addedElement of addedEllements)
        {
            let element=React.createElement(Privilege,{key:addedElement.slug, Categories:this.categories,RoleOrUser:addedElement,Id:'catid_'+addedElement.slug,PrivilegeUpdated:this.PrivilegeUpdated.bind(this)});
            let div=document.createElement('div');
            ReactDOM.render(element,div,function(){
                let element=ReactDOM.findDOMNode(this);
                itemContainer.appendChild(element);
                self.shuffle.add([element]);
                (self.shuffle as any)._onResize();
            });
        }

        for(let removedElement of removedElements)
        {
            this.shuffle.remove([document.querySelector('#catid_'+removedElement.slug)]);
        }

        this.roleOrUsers=result;


        this.setState({loading:false});
    }

    public PrivilegeUpdated(roleOrUser:RoleOrUser)
    {
        for(let i=0;i<this.roleOrUsers.length;i++)
            if(this.roleOrUsers[i].slug==roleOrUser.slug)
                this.roleOrUsers[i]={...roleOrUser};
    }
}



interface AppState{
    saving:boolean;
    filterString:string;
    loading:boolean;
}

jQuery(()=> {
    ReactDOM.render(<App></App>, document.getElementById('wcrbc-main'));
});