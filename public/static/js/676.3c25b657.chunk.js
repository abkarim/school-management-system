"use strict";(self.webpackChunkadmin=self.webpackChunkadmin||[]).push([[676],{1676:function(e,t,r){r.r(t),r.d(t,{default:function(){return g}});var a=r(8683),s=r(4165),n=r(5861),u=r(885),i=r(9061),o=r(3412),c=r(6459),l=r(184);function p(e){var t=Object.assign({},((0,c.Z)(e),e));return(0,l.jsx)("input",(0,a.Z)({type:"text",className:"bg-slate-100 border-gray-500  border-2 p-1 rounded-sm w-full focus:border-gray-800 text-lg text-gray-900"},t))}var d=r(6393),m=r(2044),x=r(7441),Z=r(7689),f=r(5761),v=r(2791),w=r(2460),j=r(3999),h=r(4718);function g(){var e=(0,Z.s0)(),t=(0,v.useState)(!1),r=(0,u.Z)(t,2),c=r[0],g=r[1],b=(0,v.useState)(!0),y=(0,u.Z)(b,2),k=y[0],N=y[1],C=(0,v.useState)({}),P=(0,u.Z)(C,2),E=P[0],I=P[1],S=(0,v.useState)({name:"",email:"",password:"",cPassword:""}),O=(0,u.Z)(S,2),B=O[0],F=O[1];(0,f.Z)(k),(0,v.useEffect)((function(){x.Z.get("/user/super-admin").then((function(){g(!1),N(!1)})).catch((function(){return g(!0)}))}),[]);var G=function(){var t=(0,n.Z)((0,s.Z)().mark((function t(){return(0,s.Z)().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!((0,j.Z)(B.name)||(0,j.Z)(B.email)||(0,j.Z)(B.password)||(0,j.Z)(B.cPassword))){t.next=2;break}return t.abrupt("return",I({text:"please fill all the input",type:"error"}));case 2:if((0,h.Z)(B.email)){t.next=4;break}return t.abrupt("return",I({text:"please enter a valid email",type:"error"}));case 4:if(B.password===B.cPassword){t.next=6;break}return t.abrupt("return",I({text:"passwords not matched",type:"error"}));case 6:return t.prev=6,t.next=9,x.Z.post("/user/super-admin",{name:B.name.trim(),email:B.email.trim(),password:B.password.trim()},{headers:{"content-type":"application/json"}});case 9:e("/login/super-admin"),t.next=15;break;case 12:t.prev=12,t.t0=t.catch(6),I({text:t.t0.response.data.message[0],type:"error"});case 15:case"end":return t.stop()}}),t,null,[[6,12]])})));return function(){return t.apply(this,arguments)}}();return c?(0,l.jsx)(Z.Fg,{to:"/"}):(0,l.jsxs)("div",{className:"bg-white max-w-lg flex-grow rounded-sm shadow-2xl box-content p-4",children:[(0,l.jsx)("div",{className:"p-2"}),(0,l.jsx)("h1",{className:"text-3xl text-gray-900 font-lato font-semibold tracking-normal",children:"Create super user"}),(0,l.jsx)("div",{className:"p-2"}),(0,l.jsx)(o.Z,{children:"Enter name"}),(0,l.jsx)(p,{value:B.name,onInput:function(e){return F((0,a.Z)((0,a.Z)({},B),{},{name:e.target.value}))}}),(0,l.jsx)("div",{className:"p-2"}),(0,l.jsx)(o.Z,{children:"Enter email"}),(0,l.jsx)(i.Z,{value:B.email,onInput:function(e){return F((0,a.Z)((0,a.Z)({},B),{},{email:e.target.value}))}}),(0,l.jsx)("div",{className:"p-2"}),(0,l.jsx)(o.Z,{children:"Enter password"}),(0,l.jsx)(d.Z,{value:B.password,onInput:function(e){return F((0,a.Z)((0,a.Z)({},B),{},{password:e.target.value}))}}),(0,l.jsx)("div",{className:"p-2"}),(0,l.jsx)(o.Z,{children:"Confirm password"}),(0,l.jsx)(d.Z,{value:B.cPassword,onInput:function(e){return F((0,a.Z)((0,a.Z)({},B),{},{cPassword:e.target.value}))}}),(0,l.jsx)("div",{className:"p-3"}),(0,l.jsx)(m.Z,{onClick:G,children:"Create user"}),(0,l.jsx)("div",{className:"p-2"}),E.text&&(0,l.jsx)(w.Z,{type:E.type,onClose:function(){return I({})},closeOnBGClick:!0,children:E.text})]})}}}]);
//# sourceMappingURL=676.3c25b657.chunk.js.map