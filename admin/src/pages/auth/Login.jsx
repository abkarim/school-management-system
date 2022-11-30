import { useState } from "react";
import Button from "../../components/button/Button";
import CheckBox from "../../components/input/Checkbox";
import EmailInput from "../../components/input/EmailInput";
import Label from "../../components/input/Label";
import PasswordInput from "../../components/input/PasswordInput";
import useUpdateTitle from "../../hooks/useUpdateTitle";
import Link from "../../components/util/Link";

/**
 * Login page
 * @returns {React.ReactElement}
 */
function Login() {
  useUpdateTitle("Login");

  const [checked, setChecked] = useState(false);
  const toggleChecked = () => setChecked(!checked);

  return (
    <div className="bg-white p-2 max-w-lg flex-grow rounded-sm shadow-2xl">
      <div className="p-2"></div>
      <h1 className="text-3xl text-gray-900 font-semibold tracking-normal">
        Student login
      </h1>
      <p>
        <Link to="/login">not student? login as other user</Link>
      </p>

      <div className="p-2"></div>
      <Label>Email</Label>
      <EmailInput name="email" />

      <div className="p-1"></div>

      <Label>Password</Label>
      <PasswordInput name="password" />

      <div className="flex justify-between mt-1">
        <div>
          <CheckBox checked={checked} onChange={toggleChecked} />
          <span className="ml-1"></span>
          <Label small={true} onClick={toggleChecked}>
            remember me
          </Label>
        </div>
        <div>
          <Label small={true}>forgot password?</Label>
        </div>
      </div>

      <div className="p-2"></div>
      <Button>Login</Button>
      <div className="p-2"></div>
    </div>
  );
}

export default Login;
