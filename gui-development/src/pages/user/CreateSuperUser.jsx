import EmailInput from "../../components/input/EmailInput";
import Label from "../../components/input/Label";
import TextInput from "../../components/input/TextInput";
import PasswordInput from "../../components/input/PasswordInput";
import Button from "../../components/button/Button";
import http from "../../util/http";
import { Navigate, useNavigate } from "react-router-dom";
import useLoading from "../../hooks/useLoading";
import { useEffect, useState } from "react";
import Notification from "../../components/Notification";
import isEmpty from "../../util/isEmpty";
import isEmail from "../../util/isEmail";
/**
 * ! Error in this file
 */
// import isEmail from "../../util/isEmail";

export default function CreateSuperUser() {
  const navigate = useNavigate();
  const [userExists, setUserExists] = useState(false);
  const [loading, setLoading] = useState(true);
  const [notification, setNotification] = useState({})
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    cPassword: ''
  })

  useLoading(loading);

  useEffect(() => {
    http
      .get("/user/super-admin")
      .then(() => {
        setUserExists(false);
        setLoading(false);
      })
      .catch(() => setUserExists(true));
  }, []);

  const submit = async () => {
    if (
      isEmpty(formData.name) || isEmpty(formData.email) ||
      isEmpty(formData.password) || isEmpty(formData.cPassword)
    ) return setNotification({
      text: "please fill all the input",
      type: 'error'
    })


    if (!isEmail(formData.email)) return setNotification({
      text: "please enter a valid email",
      type: 'error'
    })

    if (formData.password !== formData.cPassword) return setNotification({
      text: "passwords not matched",
      type: 'error'
    })

    try {
      await http.post("/user/super-admin", {
        name: formData.name.trim(),
        email: formData.email.trim(),
        password: formData.password.trim(),
      }, {
        headers: {
          "content-type": "application/json",
        },
      });
      navigate('/login/super-admin')
    } catch (error) {
      setNotification({
        text: error.response.data.message[0],
        type: 'error'
      })
    }
  };

  return userExists ? (
    <Navigate to="/" />
  ) : (
    <div className="bg-white max-w-lg flex-grow rounded-sm shadow-2xl box-content p-4">
      <div className="p-2"></div>
      <h1 className="text-3xl text-gray-900 font-lato font-semibold tracking-normal">
        Create super user
      </h1>
      <div className="p-2"></div>
      <Label>Enter name</Label>
      <TextInput value={formData.name} onInput={(e) => setFormData({ ...formData, name: e.target.value })} />
      <div className="p-2"></div>
      <Label>Enter email</Label>
      <EmailInput value={formData.email} onInput={(e) => setFormData({ ...formData, email: e.target.value })} />
      <div className="p-2"></div>
      <Label>Enter password</Label>
      <PasswordInput value={formData.password} onInput={(e) => setFormData({ ...formData, password: e.target.value })} />
      <div className="p-2"></div>
      <Label>Confirm password</Label>
      <PasswordInput value={formData.cPassword} onInput={(e) => setFormData({ ...formData, cPassword: e.target.value })} />
      <div className="p-3"></div>
      <Button onClick={submit}>Create user</Button>
      <div className="p-2"></div>
      {notification.text &&
        <Notification type={notification.type} onClose={() => setNotification({})} closeOnBGClick={true}>
          {notification.text}
        </Notification>
      }
    </div>
  );
}
