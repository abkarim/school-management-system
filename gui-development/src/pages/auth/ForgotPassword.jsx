import { useState } from "react";
import { useParams } from "react-router-dom";
import Button from "../../components/button/Button";
import EmailInput from "../../components/input/EmailInput";
import Label from "../../components/input/Label";

export default function ForgotPassword() {
  const { role } = useParams();
  const [remainingTime, setRemainingTime] = useState();
  let interval = null;

  const startCountDown = () => {
    interval = setInterval(() => {
      if (remainingTime === 0) {
        return clearInterval(interval);
      }
      setRemainingTime(remainingTime - 1);
    }, 1000);
  };

  return (
    <div className="bg-white p-2 max-w-lg flex-grow rounded-sm shadow-2xl">
      <div className="p-2"></div>
      <h1 className="text-3xl text-gray-900 font-semibold tracking-normal">
        Forgot {role} password
      </h1>
      <div className="p-2"></div>
      <Label>Enter email to reset password</Label>
      <div className="p-1"></div>
      <EmailInput />

      <div className="p-3"></div>
      <Button onClick={startCountDown}>Send password reset email</Button>
      <div className="p-2"></div>

      <p>
        A email was just sent, please check the email and follow instructions.
        &nbsp;
        <span
          className={`underline ${
            remainingTime === 0
              ? "cursor-pointer hover:text-teal-600"
              : "cursor-not-allowed"
          }`}
        >
          send again {remainingTime > 0 ? remainingTime : ""}
        </span>
      </p>
      <div className="p-2"></div>
    </div>
  );
}
