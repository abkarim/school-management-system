import "./css/App.css";
import { Routes, Route, Outlet } from "react-router-dom";
import { lazy, Suspense } from "react";
import Loading from "./components/Loading";
const NotFound = lazy(() => import("./pages/NotFound"))
const Default = lazy(() => import("./pages/auth/Default"))
const ForgotPassword = lazy(() => import("./pages/auth/ForgotPassword"))
const ResetPassword = lazy(() => import("./pages/auth/ResetPassword"))
const CreateSuperUser = lazy(() => import("./pages/user/CreateSuperUser"))
const Login = lazy(() => import("./pages/auth/Login"));
const Center = lazy(() => import("./components/Center"));

function App() {
  return (
    <Suspense fallback={<Loading />}>
      <Routes>

        <Route path="/" element={<h1>Hi</h1>} />
        {/* Create super user */}
        <Route
          path="/create-super-admin"
          element={
            <Center>
              <CreateSuperUser />
            </Center>
          }
        />
        {/* Login */}
        <Route
          path="/login"
          element={
            <Center>
              <Outlet />
            </Center>
          }
        >
          <Route index element={<Default />} />
          <Route path=":role">
            <Route index element={<Login />} />
            <Route path="forgot-password" element={<ForgotPassword />} />
            <Route path="reset-password" element={<ResetPassword />} />
          </Route>
        </Route>
        <Route
          path="*"
          element={
            <Center>
              <NotFound />
            </Center>
          }
        />
      </Routes>
    </Suspense>
  );
}
export default App;
