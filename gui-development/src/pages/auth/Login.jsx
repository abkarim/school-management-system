import { useState } from "react";
import Button from "../../components/button/Button";
import CheckBox from "../../components/input/Checkbox";
import EmailInput from "../../components/input/EmailInput";
import Label from "../../components/input/Label";
import PasswordInput from "../../components/input/PasswordInput";
import useUpdateTitle from "../../hooks/useUpdateTitle";
import Link from "../../components/util/Link";
import { useParams } from "react-router-dom";

/**
 * Login page
 */
function Login() {
  useUpdateTitle("Login");

  /** Remember user checkbox */
  const [checked, setChecked] = useState(false);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  /** Role handle user dynamically */
  const { role } = useParams();

  const toggleChecked = () => setChecked(!checked);

  /**
   * Login request for user
   */
  const login = () => {
    if (email.length < 1) return console.log("Please enter email");
    if (password.length < 1) return console.log("Please enter password");

    
  };

  return (
    <div className="bg-white p-2 max-w-lg flex-grow rounded-sm shadow-2xl">
      <div className="p-2"></div>
      <h1 className="text-3xl text-gray-900 font-semibold tracking-normal">
        {role} login
      </h1>
      <p>
        <Link to="/login">not {role}?</Link> login as other user
      </p>

      <div className="p-2"></div>
      <Label>Email</Label>
      <EmailInput
        name="email"
        value={email}
        onInput={(e) => setEmail(e.target.value)}
      />

      <div className="p-1"></div>

      <Label>Password</Label>
      <PasswordInput
        name="password"
        value={password}
        onInput={(e) => setPassword(e.target.value)}
      />

      <div className="flex justify-between mt-1">
        <div>
          <CheckBox checked={checked} onChange={toggleChecked} />
          <span className="ml-1"></span>
          <Label small={true} onClick={toggleChecked}>
            remember me
          </Label>
        </div>
        <div>
          <Label small={true}>
            <Link to={`/login/${role}/forgot-password`}>forgot password?</Link>
          </Label>
        </div>
      </div>

      <div className="p-2"></div>
      <Button onClick={login}>Login</Button>
      <div className="p-2"></div>
    </div>
  );
}

export default Login;
