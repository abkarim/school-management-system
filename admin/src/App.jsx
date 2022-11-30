import { Routes, Route } from "react-router-dom";
import Login from "./pages/auth/Login";
import "./css/App.css";
import Center from "./components/util/Center";
import NotFound from "./pages/NotFound";
function App() {
  return (
    <Routes>
      <Route path="/login">
        <Route index element={<h1>Login</h1>} />
        <Route
          path="student"
          element={
            <Center>
              <Login />
            </Center>
          }
        />
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
