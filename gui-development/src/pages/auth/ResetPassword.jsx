import Button from "../../components/button/Button";
import Label from "../../components/input/Label";
import PasswordInput from "../../components/input/PasswordInput";

export default function ResetPassword() {
  return (
    <div className="bg-white p-2 max-w-lg flex-grow rounded-sm shadow-2xl">
      <h1 className="text-3xl text-gray-900 font-semibold tracking-normal">
        Reset password
      </h1>
      <Label>Enter new password</Label>
      <PasswordInput />
      <Button>Update password</Button>
    </div>
  );
}
