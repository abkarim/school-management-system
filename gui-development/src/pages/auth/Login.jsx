import { useState } from "react";
import Button from "../../components/button/Button";
import CheckBox from "../../components/input/Checkbox";
import EmailInput from "../../components/input/EmailInput";
import Label from "../../components/input/Label";
import PasswordInput from "../../components/input/PasswordInput";
import useUpdateTitle from "../../hooks/useUpdateTitle";
import Link from "../../components/Link";
import { useNavigate, useParams } from "react-router-dom";
import http from "../../util/http";
import Notification from "../../components/Notification";
import isEmpty from "../../util/isEmpty";
import isEmail from "../../util/isEmail";
import useLoading from "../../hooks/useLoading";
import { useEffect } from "react";

/**
 * Login page
 */
function Login() {
  const [checked, setChecked] = useState(false);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [notification, setNotification] = useState({})
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate()
  useLoading(loading);
  
  /** Handle user role dynamically */
  const { role } = useParams();
  
  useUpdateTitle(`${role} login`);

  useEffect(() => {
    if (role !== 'student' && role !== 'parent' && role !== 'teacher' && role !== 'librarian' && role !== 'accountant' && role !== 'admin' && role !== 'super-admin')
      navigate('/login');
  }, [navigate, role])

  const toggleChecked = () => setChecked(!checked);

  /**
   * Login request for user
   */
  const login = async () => {
    if (isEmpty(email)) return setNotification({
      text: 'email is required',
      type: 'error'
    });

    if (isEmpty(password)) return setNotification({
      text: 'password is required',
      type: 'error'
    });

    if (!isEmail(email)) return setNotification({
      text: 'please enter a valid email',
      type: 'error'
    });

    setLoading(true);

    try {
      await http.post(
        `login/${role}`,
        { email, password, onetime: !checked },
        {
          headers: {
            "content-type": "application/json",
          },
        }
      );

      setNotification({
        text: 'logged in success, redirecting please wait...',
        type: 'success'
      })

      navigate('/')

    } catch (error) {
      setNotification({
        text: error.response.data.message[0],
        type: 'error'
      })
    } finally {
      setLoading(false)
    }
  };

  return (
    <div className="bg-white p-4 max-w-lg flex-grow rounded-sm shadow-2xl">
      <div className="p-2"></div>
      <h1 className="text-3xl text-gray-900 font-semibold tracking-normal font-lato">
        {role.slice(0, 1).toUpperCase()}{role.slice(1)} login
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
      {notification.text &&
        <Notification type={notification.type} onClose={() => setNotification({})} closeOnBGClick={true}>
          {notification.text}
        </Notification>
      }
    </div>
  );
}

export default Login;
