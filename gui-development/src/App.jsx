import "./css/App.css";
import { Routes, Route, Outlet } from "react-router-dom";
import { lazy, Suspense } from "react";
import Loading from "./components/Loading";
const Dashboard = lazy(() => import("./pages/Dashboard"));
const NotFound = lazy(() => import("./pages/NotFound"))
const Default = lazy(() => import("./pages/auth/Default"))
const ForgotPassword = lazy(() => import("./pages/auth/ForgotPassword"))
const LoginHandler = lazy(() => import("./pages/auth/LoginHandler"))
const ResetPassword = lazy(() => import("./pages/auth/ResetPassword"))
const CreateSuperUser = lazy(() => import("./pages/CreateSuperUser"))
const Login = lazy(() => import("./pages/auth/Login"));
const Center = lazy(() => import("./components/Center"));

function App() {
  return (
    <Suspense fallback={<Loading />}>
      <Routes>
        {/* Create super user */}
        <Route path="/create-super-admin" element={<Center><CreateSuperUser /></Center>} />
        {/* Login */}
        <Route path="/login" element={<LoginHandler><Outlet /></LoginHandler>}>
          <Route index element={<Default />} />
          <Route path=":role">
            <Route index element={<Login />} />
            <Route path="forgot-password" element={<ForgotPassword />} />
            <Route path="reset-password" element={<ResetPassword />} />
          </Route>
        </Route>
        {/* Dashboard */}
        <Route path="/" element={<Dashboard><Outlet /></Dashboard>}>
          <Route index />
        </Route>
        {/* 404 */}
        <Route path="*" element={<Center> <NotFound /></Center>} />
      </Routes>
    </Suspense>
  );
}
export default App;
