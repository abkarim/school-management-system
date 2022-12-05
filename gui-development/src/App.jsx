import { Routes, Route } from "react-router-dom";
import Login from "./pages/auth/Login";
import "./css/App.css";
import Center from "./components/Center";
import NotFound from "./pages/NotFound";
import Default from "./pages/auth/Default";
import ForgotPassword from "./pages/auth/ForgotPassword";
import ResetPassword from "./pages/auth/ResetPassword";
import CreateSuperUser from "./pages/user/CreateSuperUser";

function App() {
  return (
    <Routes>
      <Route
        path="/"
        element={
          <Center>
            <CreateSuperUser />
          </Center>
        }
      />
      {/* Login Route */}
      <Route path="/login">
        <Route
          index
          element={
            <Center>
              <Default />
            </Center>
          }
        />
        <Route path=":role">
          {/* Login page */}
          <Route
            index
            element={
              <Center>
                <Login />
              </Center>
            }
          />
          {/* Forgot password */}
          <Route
            path="forgot-password"
            element={
              <Center>
                <ForgotPassword />
              </Center>
            }
          />
          {/* Reset password */}
          <Route
            path="reset-password"
            element={
              <Center>
                <ResetPassword />
              </Center>
            }
          />
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
  );
}
export default App;
